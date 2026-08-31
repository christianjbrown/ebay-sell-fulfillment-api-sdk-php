<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EbayFulfillmentProgramInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayInternationalShippingInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayShippingInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayVaultProgramInterface;
use ChristianBrown\EBay\SellFulfillment\Model\PostSaleAuthenticationProgramInterface;
use ChristianBrown\EBay\SellFulfillment\Model\Program;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayFulfillmentProgramTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayInternationalShippingTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayShippingTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayVaultProgramTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\PostSaleAuthenticationProgramTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ProgramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Program::class)]
#[CoversClass(ProgramTransformer::class)]
final class ProgramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $authenticityVerificationData = ['__authenticityVerification__'];
        $ebayInternationalShippingData = ['__ebayInternationalShipping__'];
        $ebayShippingData = ['__ebayShipping__'];
        $ebayVaultData = ['__ebayVault__'];
        $fulfillmentProgramData = ['__fulfillmentProgram__'];

        $authenticityVerification = self::createStub(PostSaleAuthenticationProgramInterface::class);
        $ebayInternationalShipping = self::createStub(EbayInternationalShippingInterface::class);
        $ebayShipping = self::createStub(EbayShippingInterface::class);
        $ebayVault = self::createStub(EbayVaultProgramInterface::class);
        $fulfillmentProgram = self::createStub(EbayFulfillmentProgramInterface::class);

        $ebayFulfillmentProgramTransformer = self::createStub(EbayFulfillmentProgramTransformerInterface::class);
        $ebayFulfillmentProgramTransformer->method('transform')
            ->willReturnMap(
                [
                    [$fulfillmentProgramData, $fulfillmentProgram],
                ]
            );
        $ebayInternationalShippingTransformer = self::createStub(EbayInternationalShippingTransformerInterface::class);
        $ebayInternationalShippingTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayInternationalShippingData, $ebayInternationalShipping],
                ]
            );
        $ebayShippingTransformer = self::createStub(EbayShippingTransformerInterface::class);
        $ebayShippingTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayShippingData, $ebayShipping],
                ]
            );
        $ebayVaultProgramTransformer = self::createStub(EbayVaultProgramTransformerInterface::class);
        $ebayVaultProgramTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayVaultData, $ebayVault],
                ]
            );
        $postSaleAuthenticationProgramTransformer = self::createStub(PostSaleAuthenticationProgramTransformerInterface::class);
        $postSaleAuthenticationProgramTransformer->method('transform')
            ->willReturnMap(
                [
                    [$authenticityVerificationData, $authenticityVerification],
                ]
            );

        $data = [
            ProgramTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => $authenticityVerificationData,
            ProgramTransformerInterface::KEY_EBAY_INTERNATIONAL_SHIPPING => $ebayInternationalShippingData,
            ProgramTransformerInterface::KEY_EBAY_SHIPPING => $ebayShippingData,
            ProgramTransformerInterface::KEY_EBAY_VAULT => $ebayVaultData,
            ProgramTransformerInterface::KEY_FULFILLMENT_PROGRAM => $fulfillmentProgramData,
        ];

        $transformer = new ProgramTransformer($ebayFulfillmentProgramTransformer, $ebayInternationalShippingTransformer, $ebayShippingTransformer, $ebayVaultProgramTransformer, $postSaleAuthenticationProgramTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($authenticityVerification, $actual->getAuthenticityVerification());
        self::assertSame($ebayInternationalShipping, $actual->getEbayInternationalShipping());
        self::assertSame($ebayShipping, $actual->getEbayShipping());
        self::assertSame($ebayVault, $actual->getEbayVault());
        self::assertSame($fulfillmentProgram, $actual->getFulfillmentProgram());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAuthenticityVerificationNotSetCases')]
    public function testTransformAuthenticityVerificationNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getAuthenticityVerification());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAuthenticityVerificationNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ProgramTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayInternationalShippingNotSetCases')]
    public function testTransformEbayInternationalShippingNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getEbayInternationalShipping());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayInternationalShippingNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ProgramTransformerInterface::KEY_EBAY_INTERNATIONAL_SHIPPING => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayShippingNotSetCases')]
    public function testTransformEbayShippingNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getEbayShipping());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayShippingNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ProgramTransformerInterface::KEY_EBAY_SHIPPING => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayVaultNotSetCases')]
    public function testTransformEbayVaultNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getEbayVault());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayVaultNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ProgramTransformerInterface::KEY_EBAY_VAULT => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFulfillmentProgramNotSetCases')]
    public function testTransformFulfillmentProgramNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getFulfillmentProgram());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformFulfillmentProgramNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ProgramTransformerInterface::KEY_FULFILLMENT_PROGRAM => 'not-an-array']];
    }

    private function buildTransformer(): ProgramTransformer
    {
        $ebayFulfillmentProgramTransformer = self::createStub(EbayFulfillmentProgramTransformerInterface::class);
        $ebayInternationalShippingTransformer = self::createStub(EbayInternationalShippingTransformerInterface::class);
        $ebayShippingTransformer = self::createStub(EbayShippingTransformerInterface::class);
        $ebayVaultProgramTransformer = self::createStub(EbayVaultProgramTransformerInterface::class);
        $postSaleAuthenticationProgramTransformer = self::createStub(PostSaleAuthenticationProgramTransformerInterface::class);

        return new ProgramTransformer($ebayFulfillmentProgramTransformer, $ebayInternationalShippingTransformer, $ebayShippingTransformer, $ebayVaultProgramTransformer, $postSaleAuthenticationProgramTransformer);
    }
}
