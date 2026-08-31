<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\TrackingInfoInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class TrackingInfosTransformer implements TrackingInfosTransformerInterface
{
    private TrackingInfoTransformerInterface $trackingInfoTransformer;

    public function __construct(TrackingInfoTransformerInterface $trackingInfoTransformer)
    {
        $this->trackingInfoTransformer = $trackingInfoTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $trackingInfos[] = $this->trackingInfoTransformer->transform($value);
        }

        return $trackingInfos;
    }
}
