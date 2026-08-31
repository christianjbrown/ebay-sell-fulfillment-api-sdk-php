<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidence;
use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidenceInterface;

use function is_array;
use function is_string;

final class DisputeEvidenceTransformer implements DisputeEvidenceTransformerInterface
{
    private FileInfosTransformerInterface $fileInfosTransformer;
    private OrderLineItemsTransformerInterface $orderLineItemsTransformer;
    private TrackingInfosTransformerInterface $trackingInfosTransformer;

    public function __construct(FileInfosTransformerInterface $fileInfosTransformer, OrderLineItemsTransformerInterface $orderLineItemsTransformer, TrackingInfosTransformerInterface $trackingInfosTransformer)
    {
        $this->fileInfosTransformer = $fileInfosTransformer;
        $this->orderLineItemsTransformer = $orderLineItemsTransformer;
        $this->trackingInfosTransformer = $trackingInfosTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DisputeEvidenceInterface
    {
        $disputeEvidence = new DisputeEvidence();

        self::applyEvidenceId($disputeEvidence, $data);
        self::applyEvidenceType($disputeEvidence, $data);
        $this->applyFiles($disputeEvidence, $data);
        $this->applyLineItems($disputeEvidence, $data);
        self::applyProvidedDate($disputeEvidence, $data);
        self::applyRequestDate($disputeEvidence, $data);
        self::applyRespondByDate($disputeEvidence, $data);
        $this->applyShipmentTracking($disputeEvidence, $data);

        return $disputeEvidence;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEvidenceId(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_EVIDENCE_ID])) {
            return;
        }
        $disputeEvidence->setEvidenceId($data[self::KEY_EVIDENCE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEvidenceType(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_EVIDENCE_TYPE])) {
            return;
        }
        $disputeEvidence->setEvidenceType($data[self::KEY_EVIDENCE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFiles(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_FILES])) {
            return;
        }
        if (!is_array($data[self::KEY_FILES])) {
            return;
        }
        $disputeEvidence->setFiles($this->fileInfosTransformer->transform($data[self::KEY_FILES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItems(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        $disputeEvidence->setLineItems($this->orderLineItemsTransformer->transform($data[self::KEY_LINE_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProvidedDate(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_PROVIDED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_PROVIDED_DATE])) {
            return;
        }
        $disputeEvidence->setProvidedDate($data[self::KEY_PROVIDED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRequestDate(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_REQUEST_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_REQUEST_DATE])) {
            return;
        }
        $disputeEvidence->setRequestDate($data[self::KEY_REQUEST_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRespondByDate(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        $disputeEvidence->setRespondByDate($data[self::KEY_RESPOND_BY_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShipmentTracking(DisputeEvidence $disputeEvidence, array $data): void
    {
        if (empty($data[self::KEY_SHIPMENT_TRACKING])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPMENT_TRACKING])) {
            return;
        }
        $disputeEvidence->setShipmentTracking($this->trackingInfosTransformer->transform($data[self::KEY_SHIPMENT_TRACKING]));
    }
}
