<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AmountInterface;
use ChristianBrown\EBay\SellFulfillment\Model\AppliedPromotionInterface;
use ChristianBrown\EBay\SellFulfillment\Model\DeliveryCostInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectAndRemitTaxInterface;
use ChristianBrown\EBay\SellFulfillment\Model\EbayCollectedChargesInterface;
use ChristianBrown\EBay\SellFulfillment\Model\GiftDetailsInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ItemLocationInterface;
use ChristianBrown\EBay\SellFulfillment\Model\LineItem;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemFulfillmentInstructionsInterface;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemPropertiesInterface;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemRefundInterface;
use ChristianBrown\EBay\SellFulfillment\Model\LinkedOrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Model\NameValuePairInterface;
use ChristianBrown\EBay\SellFulfillment\Model\TaxInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AmountTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppliedPromotionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\DeliveryCostTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectAndRemitTaxesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\EbayCollectedChargesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\GiftDetailsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ItemLocationTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemFulfillmentInstructionsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemPropertiesTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemRefundsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\LineItemTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\LinkedOrderLineItemsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\NameValuePairsTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\TaxesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineItem::class)]
#[CoversClass(LineItemTransformer::class)]
final class LineItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $appliedPromotionsData = ['__appliedPromotions__'];
        $deliveryCostData = ['__deliveryCost__'];
        $discountedLineItemCostData = ['__discountedLineItemCost__'];
        $ebayCollectAndRemitTaxesData = ['__ebayCollectAndRemitTaxes__'];
        $ebayCollectedChargesData = ['__ebayCollectedCharges__'];
        $giftDetailsData = ['__giftDetails__'];
        $itemLocationData = ['__itemLocation__'];
        $lineItemCostData = ['__lineItemCost__'];
        $lineItemFulfillmentInstructionsData = ['__lineItemFulfillmentInstructions__'];
        $linkedOrderLineItemsData = ['__linkedOrderLineItems__'];
        $propertiesData = ['__properties__'];
        $refundsData = ['__refunds__'];
        $taxesData = ['__taxes__'];
        $totalData = ['__total__'];
        $variationAspectsData = ['__variationAspects__'];

        $appliedPromotions = [self::createStub(AppliedPromotionInterface::class)];
        $deliveryCost = self::createStub(DeliveryCostInterface::class);
        $discountedLineItemCost = self::createStub(AmountInterface::class);
        $ebayCollectAndRemitTaxes = [self::createStub(EbayCollectAndRemitTaxInterface::class)];
        $ebayCollectedCharges = self::createStub(EbayCollectedChargesInterface::class);
        $giftDetails = self::createStub(GiftDetailsInterface::class);
        $itemLocation = self::createStub(ItemLocationInterface::class);
        $lineItemCost = self::createStub(AmountInterface::class);
        $lineItemFulfillmentInstructions = self::createStub(LineItemFulfillmentInstructionsInterface::class);
        $linkedOrderLineItems = [self::createStub(LinkedOrderLineItemInterface::class)];
        $properties = self::createStub(LineItemPropertiesInterface::class);
        $refunds = [self::createStub(LineItemRefundInterface::class)];
        $taxes = [self::createStub(TaxInterface::class)];
        $total = self::createStub(AmountInterface::class);
        $variationAspects = [self::createStub(NameValuePairInterface::class)];

        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $amountTransformer->method('transform')
            ->willReturnMap(
                [
                    [$discountedLineItemCostData, $discountedLineItemCost],
                    [$lineItemCostData, $lineItemCost],
                    [$totalData, $total],
                ]
            );
        $appliedPromotionsTransformer = self::createStub(AppliedPromotionsTransformerInterface::class);
        $appliedPromotionsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$appliedPromotionsData, $appliedPromotions],
                ]
            );
        $deliveryCostTransformer = self::createStub(DeliveryCostTransformerInterface::class);
        $deliveryCostTransformer->method('transform')
            ->willReturnMap(
                [
                    [$deliveryCostData, $deliveryCost],
                ]
            );
        $ebayCollectAndRemitTaxesTransformer = self::createStub(EbayCollectAndRemitTaxesTransformerInterface::class);
        $ebayCollectAndRemitTaxesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayCollectAndRemitTaxesData, $ebayCollectAndRemitTaxes],
                ]
            );
        $ebayCollectedChargesTransformer = self::createStub(EbayCollectedChargesTransformerInterface::class);
        $ebayCollectedChargesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$ebayCollectedChargesData, $ebayCollectedCharges],
                ]
            );
        $giftDetailsTransformer = self::createStub(GiftDetailsTransformerInterface::class);
        $giftDetailsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$giftDetailsData, $giftDetails],
                ]
            );
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $itemLocationTransformer->method('transform')
            ->willReturnMap(
                [
                    [$itemLocationData, $itemLocation],
                ]
            );
        $lineItemFulfillmentInstructionsTransformer = self::createStub(LineItemFulfillmentInstructionsTransformerInterface::class);
        $lineItemFulfillmentInstructionsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$lineItemFulfillmentInstructionsData, $lineItemFulfillmentInstructions],
                ]
            );
        $lineItemPropertiesTransformer = self::createStub(LineItemPropertiesTransformerInterface::class);
        $lineItemPropertiesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$propertiesData, $properties],
                ]
            );
        $lineItemRefundsTransformer = self::createStub(LineItemRefundsTransformerInterface::class);
        $lineItemRefundsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$refundsData, $refunds],
                ]
            );
        $linkedOrderLineItemsTransformer = self::createStub(LinkedOrderLineItemsTransformerInterface::class);
        $linkedOrderLineItemsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$linkedOrderLineItemsData, $linkedOrderLineItems],
                ]
            );
        $nameValuePairsTransformer = self::createStub(NameValuePairsTransformerInterface::class);
        $nameValuePairsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$variationAspectsData, $variationAspects],
                ]
            );
        $taxesTransformer = self::createStub(TaxesTransformerInterface::class);
        $taxesTransformer->method('transform')
            ->willReturnMap(
                [
                    [$taxesData, $taxes],
                ]
            );

        $data = [
            LineItemTransformerInterface::KEY_APPLIED_PROMOTIONS => $appliedPromotionsData,
            LineItemTransformerInterface::KEY_DELIVERY_COST => $deliveryCostData,
            LineItemTransformerInterface::KEY_DISCOUNTED_LINE_ITEM_COST => $discountedLineItemCostData,
            LineItemTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAXES => $ebayCollectAndRemitTaxesData,
            LineItemTransformerInterface::KEY_EBAY_COLLECTED_CHARGES => $ebayCollectedChargesData,
            LineItemTransformerInterface::KEY_GIFT_DETAILS => $giftDetailsData,
            LineItemTransformerInterface::KEY_ITEM_LOCATION => $itemLocationData,
            LineItemTransformerInterface::KEY_LEGACY_ITEM_ID => 'test-legacyItemId',
            LineItemTransformerInterface::KEY_LEGACY_VARIATION_ID => 'test-legacyVariationId',
            LineItemTransformerInterface::KEY_LINE_ITEM_COST => $lineItemCostData,
            LineItemTransformerInterface::KEY_LINE_ITEM_FULFILLMENT_INSTRUCTIONS => $lineItemFulfillmentInstructionsData,
            LineItemTransformerInterface::KEY_LINE_ITEM_FULFILLMENT_STATUS => 'test-lineItemFulfillmentStatus',
            LineItemTransformerInterface::KEY_LINE_ITEM_ID => 'test-lineItemId',
            LineItemTransformerInterface::KEY_LINKED_ORDER_LINE_ITEMS => $linkedOrderLineItemsData,
            LineItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 'test-listingMarketplaceId',
            LineItemTransformerInterface::KEY_PROPERTIES => $propertiesData,
            LineItemTransformerInterface::KEY_PURCHASE_MARKETPLACE_ID => 'test-purchaseMarketplaceId',
            LineItemTransformerInterface::KEY_QUANTITY => 42,
            LineItemTransformerInterface::KEY_REFUNDS => $refundsData,
            LineItemTransformerInterface::KEY_SKU => 'test-sku',
            LineItemTransformerInterface::KEY_SOLD_FORMAT => 'test-soldFormat',
            LineItemTransformerInterface::KEY_TAXES => $taxesData,
            LineItemTransformerInterface::KEY_TITLE => 'test-title',
            LineItemTransformerInterface::KEY_TOTAL => $totalData,
            LineItemTransformerInterface::KEY_VARIATION_ASPECTS => $variationAspectsData,
        ];

        $transformer = new LineItemTransformer($amountTransformer, $appliedPromotionsTransformer, $deliveryCostTransformer, $ebayCollectAndRemitTaxesTransformer, $ebayCollectedChargesTransformer, $giftDetailsTransformer, $itemLocationTransformer, $lineItemFulfillmentInstructionsTransformer, $lineItemPropertiesTransformer, $lineItemRefundsTransformer, $linkedOrderLineItemsTransformer, $nameValuePairsTransformer, $taxesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($appliedPromotions, $actual->getAppliedPromotions());
        self::assertSame($deliveryCost, $actual->getDeliveryCost());
        self::assertSame($discountedLineItemCost, $actual->getDiscountedLineItemCost());
        self::assertSame($ebayCollectAndRemitTaxes, $actual->getEbayCollectAndRemitTaxes());
        self::assertSame($ebayCollectedCharges, $actual->getEbayCollectedCharges());
        self::assertSame($giftDetails, $actual->getGiftDetails());
        self::assertSame($itemLocation, $actual->getItemLocation());
        self::assertSame('test-legacyItemId', $actual->getLegacyItemId());
        self::assertSame('test-legacyVariationId', $actual->getLegacyVariationId());
        self::assertSame($lineItemCost, $actual->getLineItemCost());
        self::assertSame($lineItemFulfillmentInstructions, $actual->getLineItemFulfillmentInstructions());
        self::assertSame('test-lineItemFulfillmentStatus', $actual->getLineItemFulfillmentStatus());
        self::assertSame('test-lineItemId', $actual->getLineItemId());
        self::assertSame($linkedOrderLineItems, $actual->getLinkedOrderLineItems());
        self::assertSame('test-listingMarketplaceId', $actual->getListingMarketplaceId());
        self::assertSame($properties, $actual->getProperties());
        self::assertSame('test-purchaseMarketplaceId', $actual->getPurchaseMarketplaceId());
        self::assertSame(42, $actual->getQuantity());
        self::assertSame($refunds, $actual->getRefunds());
        self::assertSame('test-sku', $actual->getSku());
        self::assertSame('test-soldFormat', $actual->getSoldFormat());
        self::assertSame($taxes, $actual->getTaxes());
        self::assertSame('test-title', $actual->getTitle());
        self::assertSame($total, $actual->getTotal());
        self::assertSame($variationAspects, $actual->getVariationAspects());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformAppliedPromotionsNotSetCases')]
    public function testTransformAppliedPromotionsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getAppliedPromotions());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformAppliedPromotionsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_APPLIED_PROMOTIONS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDeliveryCostNotSetCases')]
    public function testTransformDeliveryCostNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDeliveryCost());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDeliveryCostNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_DELIVERY_COST => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformDiscountedLineItemCostNotSetCases')]
    public function testTransformDiscountedLineItemCostNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getDiscountedLineItemCost());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformDiscountedLineItemCostNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_DISCOUNTED_LINE_ITEM_COST => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayCollectAndRemitTaxesNotSetCases')]
    public function testTransformEbayCollectAndRemitTaxesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getEbayCollectAndRemitTaxes());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayCollectAndRemitTaxesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_EBAY_COLLECT_AND_REMIT_TAXES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformEbayCollectedChargesNotSetCases')]
    public function testTransformEbayCollectedChargesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getEbayCollectedCharges());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformEbayCollectedChargesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_EBAY_COLLECTED_CHARGES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformGiftDetailsNotSetCases')]
    public function testTransformGiftDetailsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getGiftDetails());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformGiftDetailsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_GIFT_DETAILS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformItemLocationNotSetCases')]
    public function testTransformItemLocationNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getItemLocation());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformItemLocationNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_ITEM_LOCATION => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemCostNotSetCases')]
    public function testTransformLineItemCostNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getLineItemCost());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemCostNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_LINE_ITEM_COST => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLineItemFulfillmentInstructionsNotSetCases')]
    public function testTransformLineItemFulfillmentInstructionsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getLineItemFulfillmentInstructions());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLineItemFulfillmentInstructionsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_LINE_ITEM_FULFILLMENT_INSTRUCTIONS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLinkedOrderLineItemsNotSetCases')]
    public function testTransformLinkedOrderLineItemsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getLinkedOrderLineItems());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformLinkedOrderLineItemsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_LINKED_ORDER_LINE_ITEMS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformPropertiesNotSetCases')]
    public function testTransformPropertiesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getProperties());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformPropertiesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_PROPERTIES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformRefundsNotSetCases')]
    public function testTransformRefundsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getRefunds());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformRefundsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_REFUNDS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedLegacyItemId, ?string $expectedLegacyVariationId, ?string $expectedLineItemFulfillmentStatus, ?string $expectedLineItemId, ?string $expectedListingMarketplaceId, ?string $expectedPurchaseMarketplaceId, ?int $expectedQuantity, ?string $expectedSku, ?string $expectedSoldFormat, ?string $expectedTitle): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedLegacyItemId, $actual->getLegacyItemId());
        self::assertSame($expectedLegacyVariationId, $actual->getLegacyVariationId());
        self::assertSame($expectedLineItemFulfillmentStatus, $actual->getLineItemFulfillmentStatus());
        self::assertSame($expectedLineItemId, $actual->getLineItemId());
        self::assertSame($expectedListingMarketplaceId, $actual->getListingMarketplaceId());
        self::assertSame($expectedPurchaseMarketplaceId, $actual->getPurchaseMarketplaceId());
        self::assertSame($expectedQuantity, $actual->getQuantity());
        self::assertSame($expectedSku, $actual->getSku());
        self::assertSame($expectedSoldFormat, $actual->getSoldFormat());
        self::assertSame($expectedTitle, $actual->getTitle());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string, ?string, ?string, ?int, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null, null, null, null, null];

        yield 'legacyItemIdWrongType' => [[LineItemTransformerInterface::KEY_LEGACY_ITEM_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'legacyVariationIdWrongType' => [[LineItemTransformerInterface::KEY_LEGACY_VARIATION_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'lineItemFulfillmentStatusWrongType' => [[LineItemTransformerInterface::KEY_LINE_ITEM_FULFILLMENT_STATUS => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'lineItemIdWrongType' => [[LineItemTransformerInterface::KEY_LINE_ITEM_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'listingMarketplaceIdWrongType' => [[LineItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'purchaseMarketplaceIdWrongType' => [[LineItemTransformerInterface::KEY_PURCHASE_MARKETPLACE_ID => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'quantityZero' => [[LineItemTransformerInterface::KEY_QUANTITY => 0], null, null, null, null, null, null, 0, null, null, null];

        yield 'quantityWrongType' => [[LineItemTransformerInterface::KEY_QUANTITY => 'not-int'], null, null, null, null, null, null, null, null, null, null];

        yield 'skuWrongType' => [[LineItemTransformerInterface::KEY_SKU => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'soldFormatWrongType' => [[LineItemTransformerInterface::KEY_SOLD_FORMAT => 42], null, null, null, null, null, null, null, null, null, null];

        yield 'titleWrongType' => [[LineItemTransformerInterface::KEY_TITLE => 42], null, null, null, null, null, null, null, null, null, null];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTaxesNotSetCases')]
    public function testTransformTaxesNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getTaxes());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTaxesNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_TAXES => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformTotalNotSetCases')]
    public function testTransformTotalNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertNull($transformer->transform($data)->getTotal());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformTotalNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_TOTAL => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformVariationAspectsNotSetCases')]
    public function testTransformVariationAspectsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getVariationAspects());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformVariationAspectsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[LineItemTransformerInterface::KEY_VARIATION_ASPECTS => 'not-an-array']];
    }

    private function buildTransformer(): LineItemTransformer
    {
        $amountTransformer = self::createStub(AmountTransformerInterface::class);
        $appliedPromotionsTransformer = self::createStub(AppliedPromotionsTransformerInterface::class);
        $deliveryCostTransformer = self::createStub(DeliveryCostTransformerInterface::class);
        $ebayCollectAndRemitTaxesTransformer = self::createStub(EbayCollectAndRemitTaxesTransformerInterface::class);
        $ebayCollectedChargesTransformer = self::createStub(EbayCollectedChargesTransformerInterface::class);
        $giftDetailsTransformer = self::createStub(GiftDetailsTransformerInterface::class);
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $lineItemFulfillmentInstructionsTransformer = self::createStub(LineItemFulfillmentInstructionsTransformerInterface::class);
        $lineItemPropertiesTransformer = self::createStub(LineItemPropertiesTransformerInterface::class);
        $lineItemRefundsTransformer = self::createStub(LineItemRefundsTransformerInterface::class);
        $linkedOrderLineItemsTransformer = self::createStub(LinkedOrderLineItemsTransformerInterface::class);
        $nameValuePairsTransformer = self::createStub(NameValuePairsTransformerInterface::class);
        $taxesTransformer = self::createStub(TaxesTransformerInterface::class);

        return new LineItemTransformer($amountTransformer, $appliedPromotionsTransformer, $deliveryCostTransformer, $ebayCollectAndRemitTaxesTransformer, $ebayCollectedChargesTransformer, $giftDetailsTransformer, $itemLocationTransformer, $lineItemFulfillmentInstructionsTransformer, $lineItemPropertiesTransformer, $lineItemRefundsTransformer, $linkedOrderLineItemsTransformer, $nameValuePairsTransformer, $taxesTransformer);
    }
}
