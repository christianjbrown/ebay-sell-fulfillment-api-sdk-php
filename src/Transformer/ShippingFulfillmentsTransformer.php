<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentInterface;

use function array_values;
use function count;

final class ShippingFulfillmentsTransformer implements ShippingFulfillmentsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private ShippingFulfillmentTransformerInterface $shippingFulfillmentTransformer;

    public function __construct(ShippingFulfillmentTransformerInterface $shippingFulfillmentTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->shippingFulfillmentTransformer = $shippingFulfillmentTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ShippingFulfillmentInterface>
     */
    public function transform(array $data): array
    {
        $shippingFulfillments = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $shippingFulfillments[] = $this->shippingFulfillmentTransformer->transform($value);
        }

        return $shippingFulfillments;
    }
}
