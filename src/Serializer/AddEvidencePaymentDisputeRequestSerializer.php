<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequestInterface;

final class AddEvidencePaymentDisputeRequestSerializer implements AddEvidencePaymentDisputeRequestSerializerInterface
{
    private FileEvidencesSerializerInterface $fileEvidencesSerializer;
    private OrderLineItemsSerializerInterface $orderLineItemsSerializer;

    public function __construct(FileEvidencesSerializerInterface $fileEvidencesSerializer, OrderLineItemsSerializerInterface $orderLineItemsSerializer)
    {
        $this->fileEvidencesSerializer = $fileEvidencesSerializer;
        $this->orderLineItemsSerializer = $orderLineItemsSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): array
    {
        $data = [];

        $data = self::applyEvidenceType($data, $addEvidencePaymentDisputeRequest);
        $data = $this->applyFiles($data, $addEvidencePaymentDisputeRequest);
        $data = $this->applyLineItems($data, $addEvidencePaymentDisputeRequest);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyEvidenceType(array $data, AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): array
    {
        $value = $addEvidencePaymentDisputeRequest->getEvidenceType();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_EVIDENCE_TYPE] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyFiles(array $data, AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): array
    {
        $value = $addEvidencePaymentDisputeRequest->getFiles();
        if (empty($value)) {
            return $data;
        }
        $data[self::KEY_FILES] = $this->fileEvidencesSerializer->serialize($value);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyLineItems(array $data, AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): array
    {
        $value = $addEvidencePaymentDisputeRequest->getLineItems();
        if (empty($value)) {
            return $data;
        }
        $data[self::KEY_LINE_ITEMS] = $this->orderLineItemsSerializer->serialize($value);

        return $data;
    }
}
