<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\ContestPaymentDisputeRequest;
use ChristianBrown\EBay\SellFulfillment\Model\ReturnAddressInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ContestPaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\ContestPaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\ReturnAddressSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ContestPaymentDisputeRequest::class)]
#[CoversClass(ContestPaymentDisputeRequestSerializer::class)]
final class ContestPaymentDisputeRequestSerializerTest extends TestCase
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

        $contestPaymentDisputeRequest = (new ContestPaymentDisputeRequest())
            ->setNote('test-note')
            ->setReturnAddress($returnAddress)
            ->setRevision(42);

        $serializer = new ContestPaymentDisputeRequestSerializer($returnAddressSerializer);

        $expected = [
            ContestPaymentDisputeRequestSerializerInterface::KEY_NOTE => 'test-note',
            ContestPaymentDisputeRequestSerializerInterface::KEY_RETURN_ADDRESS => $returnAddressData,
            ContestPaymentDisputeRequestSerializerInterface::KEY_REVISION => 42,
        ];

        self::assertSame($expected, $serializer->serialize($contestPaymentDisputeRequest));
    }

    public function testSerializeEmpty(): void
    {
        $returnAddressSerializer = self::createStub(ReturnAddressSerializerInterface::class);

        $serializer = new ContestPaymentDisputeRequestSerializer($returnAddressSerializer);

        self::assertSame([], $serializer->serialize(new ContestPaymentDisputeRequest()));
    }
}
