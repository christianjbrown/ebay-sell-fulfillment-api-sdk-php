<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\UpdateEvidencePaymentDisputeRequestInterface;

final class UpdateEvidencePaymentDisputeRequestSerializer implements UpdateEvidencePaymentDisputeRequestSerializerInterface
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
    public function serialize(UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): array
    {
        $data = [];

        $data = self::applyEvidenceId($data, $updateEvidencePaymentDisputeRequest);
        $data = self::applyEvidenceType($data, $updateEvidencePaymentDisputeRequest);
        $data = $this->applyFiles($data, $updateEvidencePaymentDisputeRequest);
        $data = $this->applyLineItems($data, $updateEvidencePaymentDisputeRequest);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyEvidenceId(array $data, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): array
    {
        $value = $updateEvidencePaymentDisputeRequest->getEvidenceId();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_EVIDENCE_ID] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyEvidenceType(array $data, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): array
    {
        $value = $updateEvidencePaymentDisputeRequest->getEvidenceType();
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
    private function applyFiles(array $data, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): array
    {
        $value = $updateEvidencePaymentDisputeRequest->getFiles();
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
    private function applyLineItems(array $data, UpdateEvidencePaymentDisputeRequestInterface $updateEvidencePaymentDisputeRequest): array
    {
        $value = $updateEvidencePaymentDisputeRequest->getLineItems();
        if (empty($value)) {
            return $data;
        }
        $data[self::KEY_LINE_ITEMS] = $this->orderLineItemsSerializer->serialize($value);

        return $data;
    }
}
