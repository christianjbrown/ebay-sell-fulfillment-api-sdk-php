<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\AddEvidencePaymentDisputeRequestInterface;

interface AddEvidencePaymentDisputeRequestSerializerInterface
{
    public const string KEY_EVIDENCE_TYPE = 'evidenceType';
    public const string KEY_FILES = 'files';
    public const string KEY_LINE_ITEMS = 'lineItems';

    /**
     * @return array<string, mixed>
     */
    public function serialize(AddEvidencePaymentDisputeRequestInterface $addEvidencePaymentDisputeRequest): array;
}
