<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;

use function array_values;
use function count;

final class EvidenceRequestsTransformer implements EvidenceRequestsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private EvidenceRequestTransformerInterface $evidenceRequestTransformer;

    public function __construct(EvidenceRequestTransformerInterface $evidenceRequestTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->evidenceRequestTransformer = $evidenceRequestTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EvidenceRequestInterface>
     */
    public function transform(array $data): array
    {
        $evidenceRequests = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $evidenceRequests[] = $this->evidenceRequestTransformer->transform($value);
        }

        return $evidenceRequests;
    }
}
