<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Buyer;
use ChristianBrown\EBay\SellFulfillment\Model\ExtendedContactInterface;
use ChristianBrown\EBay\SellFulfillment\Model\TaxAddressInterface;
use ChristianBrown\EBay\SellFulfillment\Model\TaxIdentifierInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\BuyerTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ExtendedContactTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxAddressTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxIdentifierTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Buyer::class)]
#[CoversClass(BuyerTransformer::class)]
final class BuyerTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $buyerRegistrationAddressData = ['__buyerRegistrationAddress__'];
        $taxAddressData = ['__taxAddress__'];
        $taxIdentifierData = ['__taxIdentifier__'];

        $buyerRegistrationAddress = self::createStub(ExtendedContactInterface::class);
        $taxAddress = self::createStub(TaxAddressInterface::class);
        $taxIdentifier = self::createStub(TaxIdentifierInterface::class);

        $extendedContactTransformer = self::createStub(ExtendedContactTransformerInterface::class);
        $extendedContactTransformer->method('transform')
            ->willReturnMap(
                [
                    [$buyerRegistrationAddressData, $buyerRegistrationAddress],
                ]
            );
        $taxAddressTransformer = self::createStub(TaxAddressTransformerInterface::class);
        $taxAddressTransformer->method('transform')
            ->willReturnMap(
                [
                    [$taxAddressData, $taxAddress],
                ]
            );
        $taxIdentifierTransformer = self::createStub(TaxIdentifierTransformerInterface::class);
        $taxIdentifierTransformer->method('transform')
            ->willReturnMap(
                [
                    [$taxIdentifierData, $taxIdentifier],
                ]
            );

        $data = [
            BuyerTransformerInterface::KEY_BUYER_REGISTRATION_ADDRESS => $buyerRegistrationAddressData,
            BuyerTransformerInterface::KEY_TAX_ADDRESS => $taxAddressData,
            BuyerTransformerInterface::KEY_TAX_IDENTIFIER => $taxIdentifierData,
            BuyerTransformerInterface::KEY_USERNAME => 'test-username',
        ];

        $transformer = new BuyerTransformer($extendedContactTransformer, $taxAddressTransformer, $taxIdentifierTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($buyerRegistrationAddress, $actual->getBuyerRegistrationAddress());
        self::assertSame($taxAddress, $actual->getTaxAddress());
        self::assertSame($taxIdentifier, $actual->getTaxIdentifier());
        self::assertSame('test-username', $actual->getUsername());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformBuyerRegistrationAddressNotSetCases')]
    public function testTransformBuyerRegistrationAddressNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getBuyerRegistrationAddress());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformBuyerRegistrationAddressNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[BuyerTransformerInterface::KEY_BUYER_REGISTRATION_ADDRESS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedUsername): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedUsername, $actual->getUsername());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null];

        yield 'usernameWrongType' => [[BuyerTransformerInterface::KEY_USERNAME => 42], null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTaxAddressNotSetCases')]
    public function testTransformTaxAddressNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTaxAddress());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTaxAddressNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[BuyerTransformerInterface::KEY_TAX_ADDRESS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTaxIdentifierNotSetCases')]
    public function testTransformTaxIdentifierNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTaxIdentifier());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTaxIdentifierNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[BuyerTransformerInterface::KEY_TAX_IDENTIFIER => 'not-an-array']];
    }

    private function buildTransformer(): BuyerTransformer
    {
        $extendedContactTransformer = self::createStub(ExtendedContactTransformerInterface::class);
        $taxAddressTransformer = self::createStub(TaxAddressTransformerInterface::class);
        $taxIdentifierTransformer = self::createStub(TaxIdentifierTransformerInterface::class);

        return new BuyerTransformer($extendedContactTransformer, $taxAddressTransformer, $taxIdentifierTransformer);
    }
}
