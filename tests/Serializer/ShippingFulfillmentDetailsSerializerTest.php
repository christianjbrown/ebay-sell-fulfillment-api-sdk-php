<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentDetails;
use ChristianBrown\EBay\SellFulfillment\Serializer\LineItemReferencesSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ShippingFulfillmentDetailsSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ShippingFulfillmentDetailsSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippingFulfillmentDetails::class)]
#[CoversClass(ShippingFulfillmentDetailsSerializer::class)]
final class ShippingFulfillmentDetailsSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $lineItemsData = ['__lineItems__'];

        $lineItems = [self::createStub(LineItemReferenceInterface::class)];

        $lineItemReferencesSerializer = self::createStub(LineItemReferencesSerializerInterface::class);
        $lineItemReferencesSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$lineItems, $lineItemsData],
                ]
            );

        $shippingFulfillmentDetails = (new ShippingFulfillmentDetails())
            ->setLineItems($lineItems)
            ->setShippedDate('test-shippedDate')
            ->setShippingCarrierCode('test-shippingCarrierCode')
            ->setTrackingNumber('test-trackingNumber');

        $serializer = new ShippingFulfillmentDetailsSerializer($lineItemReferencesSerializer);

        $expected = [
            ShippingFulfillmentDetailsSerializerInterface::KEY_LINE_ITEMS => $lineItemsData,
            ShippingFulfillmentDetailsSerializerInterface::KEY_SHIPPED_DATE => 'test-shippedDate',
            ShippingFulfillmentDetailsSerializerInterface::KEY_SHIPPING_CARRIER_CODE => 'test-shippingCarrierCode',
            ShippingFulfillmentDetailsSerializerInterface::KEY_TRACKING_NUMBER => 'test-trackingNumber',
        ];

        self::assertSame($expected, $serializer->serialize($shippingFulfillmentDetails));
    }

    public function testSerializeEmpty(): void
    {
        $lineItemReferencesSerializer = self::createStub(LineItemReferencesSerializerInterface::class);

        $serializer = new ShippingFulfillmentDetailsSerializer($lineItemReferencesSerializer);

        self::assertSame([], $serializer->serialize(new ShippingFulfillmentDetails()));
    }
}
