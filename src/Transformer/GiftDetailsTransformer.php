<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\GiftDetails;
use ChristianBrown\EBay\SellFulfillment\Model\GiftDetailsInterface;

use function is_string;

final class GiftDetailsTransformer implements GiftDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GiftDetailsInterface
    {
        $giftDetails = new GiftDetails();

        self::applyMessage($giftDetails, $data);
        self::applyRecipientEmail($giftDetails, $data);
        self::applySenderName($giftDetails, $data);

        return $giftDetails;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMessage(GiftDetails $giftDetails, array $data): void
    {
        if (empty($data[self::KEY_MESSAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_MESSAGE])) {
            return;
        }
        $giftDetails->setMessage($data[self::KEY_MESSAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRecipientEmail(GiftDetails $giftDetails, array $data): void
    {
        if (empty($data[self::KEY_RECIPIENT_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_RECIPIENT_EMAIL])) {
            return;
        }
        $giftDetails->setRecipientEmail($data[self::KEY_RECIPIENT_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySenderName(GiftDetails $giftDetails, array $data): void
    {
        if (empty($data[self::KEY_SENDER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_SENDER_NAME])) {
            return;
        }
        $giftDetails->setSenderName($data[self::KEY_SENDER_NAME]);
    }
}
