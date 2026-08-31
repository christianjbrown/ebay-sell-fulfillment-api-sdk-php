<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\ContestPaymentDisputeRequestInterface;

interface ContestPaymentDisputeRequestSerializerInterface
{
    public const string KEY_NOTE = 'note';
    public const string KEY_RETURN_ADDRESS = 'returnAddress';
    public const string KEY_REVISION = 'revision';

    /**
     * @return array<string, mixed>
     */
    public function serialize(ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): array;
}
