<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Charge;
use ChristianBrown\EBay\SellFulfillment\Model\ChargeInterface;

use function is_array;
use function is_string;

final class ChargeTransformer implements ChargeTransformerInterface
{
    private AmountTransformerInterface $amountTransformer;

    public function __construct(AmountTransformerInterface $amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ChargeInterface
    {
        $charge = new Charge();

        $this->applyAmount($charge, $data);
        self::applyChargeType($charge, $data);

        return $charge;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAmount(Charge $charge, array $data): void
    {
        if (empty($data[self::KEY_AMOUNT])) {
            return;
        }
        if (!is_array($data[self::KEY_AMOUNT])) {
            return;
        }
        $charge->setAmount($this->amountTransformer->transform($data[self::KEY_AMOUNT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChargeType(Charge $charge, array $data): void
    {
        if (empty($data[self::KEY_CHARGE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_CHARGE_TYPE])) {
            return;
        }
        $charge->setChargeType($data[self::KEY_CHARGE_TYPE]);
    }
}
