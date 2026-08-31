<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\GiftDetailsInterface;

interface GiftDetailsTransformerInterface
{
    public const string KEY_MESSAGE = 'message';
    public const string KEY_RECIPIENT_EMAIL = 'recipientEmail';
    public const string KEY_SENDER_NAME = 'senderName';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GiftDetailsInterface;
}
