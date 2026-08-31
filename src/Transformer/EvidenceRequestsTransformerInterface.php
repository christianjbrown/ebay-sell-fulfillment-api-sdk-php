<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;

interface EvidenceRequestsTransformerInterface
{
    public const string ARRAY_NAME = 'evidence_request';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, EvidenceRequestInterface>
     */
    public function transform(array $data): array;
}
