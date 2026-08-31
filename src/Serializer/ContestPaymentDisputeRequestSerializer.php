<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Serializer;

use ChristianBrown\EBay\SellFulfillment\Model\ContestPaymentDisputeRequestInterface;

final class ContestPaymentDisputeRequestSerializer implements ContestPaymentDisputeRequestSerializerInterface
{
    private ReturnAddressSerializerInterface $returnAddressSerializer;

    public function __construct(ReturnAddressSerializerInterface $returnAddressSerializer)
    {
        $this->returnAddressSerializer = $returnAddressSerializer;
    }

    /**
     * @return array<string, mixed>
     */
    public function serialize(ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): array
    {
        $data = [];

        $data = self::applyNote($data, $contestPaymentDisputeRequest);
        $data = $this->applyReturnAddress($data, $contestPaymentDisputeRequest);
        $data = self::applyRevision($data, $contestPaymentDisputeRequest);

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private static function applyNote(array $data, ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): array
    {
        $value = $contestPaymentDisputeRequest->getNote();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_NOTE] = $value;

        return $data;
    }

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function applyReturnAddress(array $data, ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): array
    {
        $value = $contestPaymentDisputeRequest->getReturnAddress();
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
    private static function applyRevision(array $data, ContestPaymentDisputeRequestInterface $contestPaymentDisputeRequest): array
    {
        $value = $contestPaymentDisputeRequest->getRevision();
        if (null === $value) {
            return $data;
        }
        $data[self::KEY_REVISION] = $value;

        return $data;
    }
}
