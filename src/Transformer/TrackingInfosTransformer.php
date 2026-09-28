<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;

use function array_values;
use function count;

final class TrackingInfosTransformer implements TrackingInfosTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private TrackingInfoTransformerInterface $trackingInfoTransformer;

    public function __construct(TrackingInfoTransformerInterface $trackingInfoTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->trackingInfoTransformer = $trackingInfoTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TrackingInfoInterface>
     */
    public function transform(array $data): array
    {
        $trackingInfos = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $trackingInfos[] = $this->trackingInfoTransformer->transform($value);
        }

        return $trackingInfos;
    }
}
