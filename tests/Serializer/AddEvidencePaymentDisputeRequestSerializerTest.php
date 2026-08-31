<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequest;
use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\AddEvidencePaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\AddEvidencePaymentDisputeRequestSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidencesSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemsSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AddEvidencePaymentDisputeRequest::class)]
#[CoversClass(AddEvidencePaymentDisputeRequestSerializer::class)]
final class AddEvidencePaymentDisputeRequestSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $filesData = ['__files__'];
        $lineItemsData = ['__lineItems__'];

        $files = [self::createStub(FileEvidenceInterface::class)];
        $lineItems = [self::createStub(OrderLineItemInterface::class)];

        $fileEvidencesSerializer = self::createStub(FileEvidencesSerializerInterface::class);
        $fileEvidencesSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$files, $filesData],
                ]
            );
        $orderLineItemsSerializer = self::createStub(OrderLineItemsSerializerInterface::class);
        $orderLineItemsSerializer->method('serialize')
            ->willReturnMap(
                [
                    [$lineItems, $lineItemsData],
                ]
            );

        $addEvidencePaymentDisputeRequest = (new AddEvidencePaymentDisputeRequest())
            ->setEvidenceType('test-evidenceType')
            ->setFiles($files)
            ->setLineItems($lineItems);

        $serializer = new AddEvidencePaymentDisputeRequestSerializer($fileEvidencesSerializer, $orderLineItemsSerializer);

        $expected = [
            AddEvidencePaymentDisputeRequestSerializerInterface::KEY_EVIDENCE_TYPE => 'test-evidenceType',
            AddEvidencePaymentDisputeRequestSerializerInterface::KEY_FILES => $filesData,
            AddEvidencePaymentDisputeRequestSerializerInterface::KEY_LINE_ITEMS => $lineItemsData,
        ];

        self::assertSame($expected, $serializer->serialize($addEvidencePaymentDisputeRequest));
    }

    public function testSerializeEmpty(): void
    {
        $fileEvidencesSerializer = self::createStub(FileEvidencesSerializerInterface::class);
        $orderLineItemsSerializer = self::createStub(OrderLineItemsSerializerInterface::class);

        $serializer = new AddEvidencePaymentDisputeRequestSerializer($fileEvidencesSerializer, $orderLineItemsSerializer);

        self::assertSame([], $serializer->serialize(new AddEvidencePaymentDisputeRequest()));
    }
}
