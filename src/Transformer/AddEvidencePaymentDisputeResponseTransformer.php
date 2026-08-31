<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponse;
use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponseInterface;

use function is_string;

final class AddEvidencePaymentDisputeResponseTransformer implements AddEvidencePaymentDisputeResponseTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AddEvidencePaymentDisputeResponseInterface
    {
        $addEvidencePaymentDisputeResponse = new AddEvidencePaymentDisputeResponse();

        self::applyEvidenceId($addEvidencePaymentDisputeResponse, $data);

        return $addEvidencePaymentDisputeResponse;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEvidenceId(AddEvidencePaymentDisputeResponse $addEvidencePaymentDisputeResponse, array $data): void
    {
        if (empty($data[self::KEY_EVIDENCE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_EVIDENCE_ID])) {
            return;
        }
        $addEvidencePaymentDisputeResponse->setEvidenceId($data[self::KEY_EVIDENCE_ID]);
    }
}
