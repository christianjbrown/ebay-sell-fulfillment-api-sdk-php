<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemProperties;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemPropertiesTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemPropertiesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItemProperties::class)]
#[CoversClass(LineItemPropertiesTransformer::class)]
final class LineItemPropertiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LineItemPropertiesTransformerInterface::KEY_BUYER_PROTECTION => true,
            LineItemPropertiesTransformerInterface::KEY_FROM_BEST_OFFER => true,
            LineItemPropertiesTransformerInterface::KEY_SOLD_VIA_AD_CAMPAIGN => true,
        ];

        $transformer = new LineItemPropertiesTransformer();

        $actual = $transformer->transform($data);

        self::assertTrue($actual->getBuyerProtection());
        self::assertTrue($actual->getFromBestOffer());
        self::assertTrue($actual->getSoldViaAdCampaign());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?bool $expectedBuyerProtection, ?bool $expectedFromBestOffer, ?bool $expectedSoldViaAdCampaign): void
    {
        $transformer = new LineItemPropertiesTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedBuyerProtection, $actual->getBuyerProtection());
        self::assertSame($expectedFromBestOffer, $actual->getFromBestOffer());
        self::assertSame($expectedSoldViaAdCampaign, $actual->getSoldViaAdCampaign());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?bool, ?bool, ?bool}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'buyerProtectionFalse' => [[LineItemPropertiesTransformerInterface::KEY_BUYER_PROTECTION => false], false, null, null];

        yield 'buyerProtectionWrongType' => [[LineItemPropertiesTransformerInterface::KEY_BUYER_PROTECTION => 'not-bool'], null, null, null];

        yield 'fromBestOfferFalse' => [[LineItemPropertiesTransformerInterface::KEY_FROM_BEST_OFFER => false], null, false, null];

        yield 'fromBestOfferWrongType' => [[LineItemPropertiesTransformerInterface::KEY_FROM_BEST_OFFER => 'not-bool'], null, null, null];

        yield 'soldViaAdCampaignFalse' => [[LineItemPropertiesTransformerInterface::KEY_SOLD_VIA_AD_CAMPAIGN => false], null, null, false];

        yield 'soldViaAdCampaignWrongType' => [[LineItemPropertiesTransformerInterface::KEY_SOLD_VIA_AD_CAMPAIGN => 'not-bool'], null, null, null];
    }
}
