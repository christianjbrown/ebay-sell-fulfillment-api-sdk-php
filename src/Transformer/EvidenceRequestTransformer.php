<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequest;
use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;

use function is_array;
use function is_string;

final class EvidenceRequestTransformer implements EvidenceRequestTransformerInterface
{
    private OrderLineItemsTransformerInterface $orderLineItemsTransformer;

    public function __construct(OrderLineItemsTransformerInterface $orderLineItemsTransformer)
    {
        $this->orderLineItemsTransformer = $orderLineItemsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EvidenceRequestInterface
    {
        $evidenceRequest = new EvidenceRequest();

        self::applyEvidenceId($evidenceRequest, $data);
        self::applyEvidenceType($evidenceRequest, $data);
        $this->applyLineItems($evidenceRequest, $data);
        self::applyRequestDate($evidenceRequest, $data);
        self::applyRespondByDate($evidenceRequest, $data);

        return $evidenceRequest;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEvidenceId(EvidenceRequest $evidenceRequest, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_EVIDENCE_ID])) {
            return;
        }
        $evidenceRequest->setEvidenceId($data[self::KEY_EVIDENCE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEvidenceType(EvidenceRequest $evidenceRequest, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_EVIDENCE_TYPE])) {
            return;
        }
        $evidenceRequest->setEvidenceType($data[self::KEY_EVIDENCE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLineItems(EvidenceRequest $evidenceRequest, array $data): void
    {
        if (empty($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        if (!is_array($data[self::KEY_LINE_ITEMS])) {
            return;
        }
        $evidenceRequest->setLineItems($this->orderLineItemsTransformer->transform($data[self::KEY_LINE_ITEMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRequestDate(EvidenceRequest $evidenceRequest, array $data): void
    {
        if (empty($data[self::KEY_REQUEST_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_REQUEST_DATE])) {
            return;
        }
        $evidenceRequest->setRequestDate($data[self::KEY_REQUEST_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRespondByDate(EvidenceRequest $evidenceRequest, array $data): void
    {
        if (empty($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_RESPOND_BY_DATE])) {
            return;
        }
        $evidenceRequest->setRespondByDate($data[self::KEY_RESPOND_BY_DATE]);
    }
}
