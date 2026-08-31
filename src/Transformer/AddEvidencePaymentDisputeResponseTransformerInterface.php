<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeResponseInterface;

interface AddEvidencePaymentDisputeResponseTransformerInterface
{
    public const string KEY_EVIDENCE_ID = 'evidenceId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AddEvidencePaymentDisputeResponseInterface;
}
