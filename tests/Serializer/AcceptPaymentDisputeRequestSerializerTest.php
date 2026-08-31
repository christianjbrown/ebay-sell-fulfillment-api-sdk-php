<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\AcceptPaymentDisputeRequest;
use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddressInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AcceptPaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\AcceptPaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ReturnAddressSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AcceptPaymentDisputeRequest::class)]
#[CoversClass(AcceptPaymentDisputeRequestSerializer::class)]
final class AcceptPaymentDisputeRequestSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $returnAddressData = ['__returnAddress__'];

        $returnAddress = self::createStub(ReturnAddressInterface::class);

        $returnAddressSerializer = self::createStub(ReturnAddressSerializerInterface::class);
        $returnAddressSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$returnAddress, $returnAddressData],
                ]
            );

        $acceptPaymentDisputeRequest = (new AcceptPaymentDisputeRequest())
            ->setReturnAddress($returnAddress)
            ->setRevision(42);

        $serializer = new AcceptPaymentDisputeRequestSerializer($returnAddressSerializer);

        $expected = [
            AcceptPaymentDisputeRequestSerializerInterface::KEY_RETURN_ADDRESS => $returnAddressData,
            AcceptPaymentDisputeRequestSerializerInterface::KEY_REVISION => 42,
        ];

        self::assertSame($expected, $serializer->serialize($acceptPaymentDisputeRequest));
    }

    public function testSerializeEmpty(): void
    {
        $returnAddressSerializer = self::createStub(ReturnAddressSerializerInterface::class);

        $serializer = new AcceptPaymentDisputeRequestSerializer($returnAddressSerializer);

        self::assertSame([], $serializer->serialize(new AcceptPaymentDisputeRequest()));
    }
}
