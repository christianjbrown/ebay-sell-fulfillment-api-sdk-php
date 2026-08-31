<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PhoneNumber;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneNumberTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PhoneNumberTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PhoneNumber::class)]
#[CoversClass(PhoneNumberTransformer::class)]
final class PhoneNumberTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PhoneNumberTransformerInterface::KEY_PHONE_NUMBER => 'test-phoneNumber',
        ];

        $transformer = new PhoneNumberTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-phoneNumber', $actual->getPhoneNumber());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedPhoneNumber): void
    {
        $transformer = new PhoneNumberTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedPhoneNumber, $actual->getPhoneNumber());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'phoneNumberWrongType' => [[PhoneNumberTransformerInterface::KEY_PHONE_NUMBER => 42], null];
    }
}
