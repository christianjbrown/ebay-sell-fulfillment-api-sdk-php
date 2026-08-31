<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddress;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ReturnAddressTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ReturnAddressTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReturnAddress::class)]
#[CoversClass(ReturnAddressTransformer::class)]
final class ReturnAddressTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $primaryPhoneData = ['__primaryPhone__'];

        $primaryPhone = self::createStub(PhoneInterface::class);

        $phoneTransformer = self::createStub(PhoneTransformerInterface::class);
        $phoneTransformer->method('transform')
            ->willReturnMap(
                [
                    [$primaryPhoneData, $primaryPhone],
                ]
            );

        $data = [
            ReturnAddressTransformerInterface::KEY_ADDRESS_LINE1 => 'test-addressLine1',
            ReturnAddressTransformerInterface::KEY_ADDRESS_LINE2 => 'test-addressLine2',
            ReturnAddressTransformerInterface::KEY_CITY => 'test-city',
            ReturnAddressTransformerInterface::KEY_COUNTRY => 'test-country',
            ReturnAddressTransformerInterface::KEY_COUNTY => 'test-county',
            ReturnAddressTransformerInterface::KEY_FULL_NAME => 'test-fullName',
            ReturnAddressTransformerInterface::KEY_POSTAL_CODE => 'test-postalCode',
            ReturnAddressTransformerInterface::KEY_PRIMARY_PHONE => $primaryPhoneData,
            ReturnAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 'test-stateOrProvince',
        ];

        $transformer = new ReturnAddressTransformer($phoneTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-addressLine1', $actual->getAddressLine1());
        self::assertSame('test-addressLine2', $actual->getAddressLine2());
        self::assertSame('test-city', $actual->getCity());
        self::assertSame('test-country', $actual->getCountry());
        self::assertSame('test-county', $actual->getCounty());
        self::assertSame('test-fullName', $actual->getFullName());
        self::assertSame('test-postalCode', $actual->getPostalCode());
        self::assertSame($primaryPhone, $actual->getPrimaryPhone());
        self::assertSame('test-stateOrProvince', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPrimaryPhoneNotSetCases')]
    public function testTransformPrimaryPhoneNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getPrimaryPhone());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPrimaryPhoneNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ReturnAddressTransformerInterface::KEY_PRIMARY_PHONE => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedAddressLine1, ?string $expectedAddressLine2, ?string $expectedCity, ?string $expectedCountry, ?string $expectedCounty, ?string $expectedFullName, ?string $expectedPostalCode, ?string $expectedStateOrProvince): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedAddressLine1, $actual->getAddressLine1());
        self::assertSame($expectedAddressLine2, $actual->getAddressLine2());
        self::assertSame($expectedCity, $actual->getCity());
        self::assertSame($expectedCountry, $actual->getCountry());
        self::assertSame($expectedCounty, $actual->getCounty());
        self::assertSame($expectedFullName, $actual->getFullName());
        self::assertSame($expectedPostalCode, $actual->getPostalCode());
        self::assertSame($expectedStateOrProvince, $actual->getStateOrProvince());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null, null, null];

        yield 'addressLine1WrongType' => [[ReturnAddressTransformerInterface::KEY_ADDRESS_LINE1 => 42], null, null, null, null, null, null, null, null];

        yield 'addressLine2WrongType' => [[ReturnAddressTransformerInterface::KEY_ADDRESS_LINE2 => 42], null, null, null, null, null, null, null, null];

        yield 'cityWrongType' => [[ReturnAddressTransformerInterface::KEY_CITY => 42], null, null, null, null, null, null, null, null];

        yield 'countryWrongType' => [[ReturnAddressTransformerInterface::KEY_COUNTRY => 42], null, null, null, null, null, null, null, null];

        yield 'countyWrongType' => [[ReturnAddressTransformerInterface::KEY_COUNTY => 42], null, null, null, null, null, null, null, null];

        yield 'fullNameWrongType' => [[ReturnAddressTransformerInterface::KEY_FULL_NAME => 42], null, null, null, null, null, null, null, null];

        yield 'postalCodeWrongType' => [[ReturnAddressTransformerInterface::KEY_POSTAL_CODE => 42], null, null, null, null, null, null, null, null];

        yield 'stateOrProvinceWrongType' => [[ReturnAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 42], null, null, null, null, null, null, null, null];
    }

    private function buildTransformer(): ReturnAddressTransformer
    {
        $phoneTransformer = self::createStub(PhoneTransformerInterface::class);

        return new ReturnAddressTransformer($phoneTransformer);
    }
}
