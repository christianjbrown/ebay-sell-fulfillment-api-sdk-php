<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\AcceptPaymentDisputeRequestInterface;

final class AcceptPaymentDisputeRequestSerializer implements AcceptPaymentDisputeRequestSerializerInterface
{
    private ReturnAddressSerializerInterface $returnAddressSerializer;

    public function __construct(ReturnAddressSerializerInterface $returnAddressSerializer)
    {
        $this->returnAddressSerializer = $returnAddressSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(AcceptPaymentDisputeRequestInterface $acceptPaymentDisputeRequest): array
    {
        $data = [];

        $data = $this->applyReturnAddress($data, $acceptPaymentDisputeRequest);
        $data = self::applyRevision($data, $acceptPaymentDisputeRequest);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyReturnAddress(array $data, AcceptPaymentDisputeRequestInterface $acceptPaymentDisputeRequest): array
    {
        $value = $acceptPaymentDisputeRequest->getReturnAddress();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_RETURN_ADDRESS] = $this->returnAddressSerializer->serialize($value);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyRevision(array $data, AcceptPaymentDisputeRequestInterface $acceptPaymentDisputeRequest): array
    {
        $value = $acceptPaymentDisputeRequest->getRevision();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_REVISION] = $value;

        return $data;
    }
}
