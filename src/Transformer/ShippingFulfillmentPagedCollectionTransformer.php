<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollection;
use ChristianBrown\EBay\SellFulfillment\Model\ShippingFulfillmentPagedCollectionInterface;

use function is_array;
use function is_int;

final class ShippingFulfillmentPagedCollectionTransformer implements ShippingFulfillmentPagedCollectionTransformerInterface
{
    private ErrorsTransformerInterface $errorsTransformer;
    private ShippingFulfillmentsTransformerInterface $shippingFulfillmentsTransformer;

    public function __construct(ErrorsTransformerInterface $errorsTransformer, ShippingFulfillmentsTransformerInterface $shippingFulfillmentsTransformer)
    {
        $this->errorsTransformer = $errorsTransformer;
        $this->shippingFulfillmentsTransformer = $shippingFulfillmentsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShippingFulfillmentPagedCollectionInterface
    {
        $shippingFulfillmentPagedCollection = new ShippingFulfillmentPagedCollection();

        $this->applyFulfillments($shippingFulfillmentPagedCollection, $data);
        self::applyTotal($shippingFulfillmentPagedCollection, $data);
        $this->applyWarnings($shippingFulfillmentPagedCollection, $data);

        return $shippingFulfillmentPagedCollection;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFulfillments(ShippingFulfillmentPagedCollection $shippingFulfillmentPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_FULFILLMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_FULFILLMENTS])) {
            return;
        }
        $shippingFulfillmentPagedCollection->setFulfillments($this->shippingFulfillmentsTransformer->transform($data[self::KEY_FULFILLMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTotal(ShippingFulfillmentPagedCollection $shippingFulfillmentPagedCollection, array $data): void
    {
        if (!isset($data[self::KEY_TOTAL])) {
            return;
        }
        if (!is_int($data[self::KEY_TOTAL])) {
            return;
        }
        $shippingFulfillmentPagedCollection->setTotal($data[self::KEY_TOTAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(ShippingFulfillmentPagedCollection $shippingFulfillmentPagedCollection, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $shippingFulfillmentPagedCollection->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
