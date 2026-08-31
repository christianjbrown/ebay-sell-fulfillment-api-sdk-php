<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AddressInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ExtendedContact;
use ChristianBrown\EBay\SellFulfillment\Model\PhoneNumberInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AddressTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneNumberTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExtendedContact::class)]
#[CoversClass(ExtendedContactTransformer::class)]
final class ExtendedContactTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $contactAddressData = ['__contactAddress__'];
        $primaryPhoneData = ['__primaryPhone__'];

        $contactAddress = self::createStub(AddressInterface::class);
        $primaryPhone = self::createStub(PhoneNumberInterface::class);

        $addressTransformer = self::createStub(AddressTransformerInterface::class);
        $addressTransformer->method('transform')
            ->willReturnMap(
                [
                    [$contactAddressData, $contactAddress],
                ]
            );
        $phoneNumberTransformer = self::createStub(PhoneNumberTransformerInterface::class);
        $phoneNumberTransformer->method('transform')
            ->willReturnMap(
                [
                    [$primaryPhoneData, $primaryPhone],
                ]
            );

        $data = [
            ExtendedContactTransformerInterface::KEY_COMPANY_NAME => 'test-companyName',
            ExtendedContactTransformerInterface::KEY_CONTACT_ADDRESS => $contactAddressData,
            ExtendedContactTransformerInterface::KEY_EMAIL => 'test-email',
            ExtendedContactTransformerInterface::KEY_FULL_NAME => 'test-fullName',
            ExtendedContactTransformerInterface::KEY_PRIMARY_PHONE => $primaryPhoneData,
        ];

        $transformer = new ExtendedContactTransformer($addressTransformer, $phoneNumberTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-companyName', $actual->getCompanyName());
        self::assertSame($contactAddress, $actual->getContactAddress());
        self::assertSame('test-email', $actual->getEmail());
        self::assertSame('test-fullName', $actual->getFullName());
        self::assertSame($primaryPhone, $actual->getPrimaryPhone());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformContactAddressNotSetCases')]
    public function testTransformContactAddressNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getContactAddress());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformContactAddressNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ExtendedContactTransformerInterface::KEY_CONTACT_ADDRESS => 'not-an-array']];
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

        yield 'nonArray' => [[ExtendedContactTransformerInterface::KEY_PRIMARY_PHONE => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCompanyName, ?string $expectedEmail, ?string $expectedFullName): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCompanyName, $actual->getCompanyName());
        self::assertSame($expectedEmail, $actual->getEmail());
        self::assertSame($expectedFullName, $actual->getFullName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'companyNameWrongType' => [[ExtendedContactTransformerInterface::KEY_COMPANY_NAME => 42], null, null, null];

        yield 'emailWrongType' => [[ExtendedContactTransformerInterface::KEY_EMAIL => 42], null, null, null];

        yield 'fullNameWrongType' => [[ExtendedContactTransformerInterface::KEY_FULL_NAME => 42], null, null, null];
    }

    private function buildTransformer(): ExtendedContactTransformer
    {
        $addressTransformer = self::createStub(AddressTransformerInterface::class);
        $phoneNumberTransformer = self::createStub(PhoneNumberTransformerInterface::class);

        return new ExtendedContactTransformer($addressTransformer, $phoneNumberTransformer);
    }
}
