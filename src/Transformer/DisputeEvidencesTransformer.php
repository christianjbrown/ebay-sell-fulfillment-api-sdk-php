<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\DisputeEvidenceInterface;

use function array_values;
use function count;

final class DisputeEvidencesTransformer implements DisputeEvidencesTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private DisputeEvidenceTransformerInterface $disputeEvidenceTransformer;

    public function __construct(DisputeEvidenceTransformerInterface $disputeEvidenceTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->disputeEvidenceTransformer = $disputeEvidenceTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DisputeEvidenceInterface>
     */
    public function transform(array $data): array
    {
        $disputeEvidences = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $disputeEvidences[] = $this->disputeEvidenceTransformer->transform($value);
        }

        return $disputeEvidences;
    }
}
