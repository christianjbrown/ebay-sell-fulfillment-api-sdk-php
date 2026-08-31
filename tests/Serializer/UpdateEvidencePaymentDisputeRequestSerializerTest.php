<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\FileEvidenceInterface;
use ChristianBrown\EBay\SellFulfillment\Model\OrderLineItemInterface;
use ChristianBrown\EBay\SellFulfillment\Model\UpdateEvidencePaymentDisputeRequest;
use ChristianBrown\EBay\SellFulfillment\Serializer\FileEvidencesSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\OrderLineItemsSerializerInterface;
use ChristianBrown\EBay\SellFulfillment\Serializer\UpdateEvidencePaymentDisputeRequestSerializer;
use ChristianBrown\EBay\SellFulfillment\Serializer\UpdateEvidencePaymentDisputeRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateEvidencePaymentDisputeRequest::class)]
#[CoversClass(UpdateEvidencePaymentDisputeRequestSerializer::class)]
final class UpdateEvidencePaymentDisputeRequestSerializerTest extends TestCase
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

        $updateEvidencePaymentDisputeRequest = (new UpdateEvidencePaymentDisputeRequest())
            ->setEvidenceId('test-evidenceId')
            ->setEvidenceType('test-evidenceType')
            ->setFiles($files)
            ->setLineItems($lineItems);

        $serializer = new UpdateEvidencePaymentDisputeRequestSerializer($fileEvidencesSerializer, $orderLineItemsSerializer);

        $expected = [
            UpdateEvidencePaymentDisputeRequestSerializerInterface::KEY_EVIDENCE_ID => 'test-evidenceId',
            UpdateEvidencePaymentDisputeRequestSerializerInterface::KEY_EVIDENCE_TYPE => 'test-evidenceType',
            UpdateEvidencePaymentDisputeRequestSerializerInterface::KEY_FILES => $filesData,
            UpdateEvidencePaymentDisputeRequestSerializerInterface::KEY_LINE_ITEMS => $lineItemsData,
        ];

        self::assertSame($expected, $serializer->serialize($updateEvidencePaymentDisputeRequest));
    }

    public function testSerializeEmpty(): void
    {
        $fileEvidencesSerializer = self::createStub(FileEvidencesSerializerInterface::class);
        $orderLineItemsSerializer = self::createStub(OrderLineItemsSerializerInterface::class);

        $serializer = new UpdateEvidencePaymentDisputeRequestSerializer($fileEvidencesSerializer, $orderLineItemsSerializer);

        self::assertSame([], $serializer->serialize(new UpdateEvidencePaymentDisputeRequest()));
    }
}
