<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;

interface EvidenceRequestTransformerInterface
{
    public const string KEY_EVIDENCE_ID = 'evidenceId';
    public const string KEY_EVIDENCE_TYPE = 'evidenceType';
    public const string KEY_LINE_ITEMS = 'lineItems';
    public const string KEY_REQUEST_DATE = 'requestDate';
    public const string KEY_RESPOND_BY_DATE = 'respondByDate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EvidenceRequestInterface;
}
