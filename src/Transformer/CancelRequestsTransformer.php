<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;

use function array_values;
use function count;

final class CancelRequestsTransformer implements CancelRequestsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private CancelRequestTransformerInterface $cancelRequestTransformer;

    public function __construct(CancelRequestTransformerInterface $cancelRequestTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->cancelRequestTransformer = $cancelRequestTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CancelRequestInterface>
     */
    public function transform(array $data): array
    {
        $cancelRequests = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $cancelRequests[] = $this->cancelRequestTransformer->transform($value);
        }

        return $cancelRequests;
    }
}
