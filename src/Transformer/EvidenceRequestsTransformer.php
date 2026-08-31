<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\EvidenceRequestInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class EvidenceRequestsTransformer implements EvidenceRequestsTransformerInterface
{
    private EvidenceRequestTransformerInterface $evidenceRequestTransformer;

    public function __construct(EvidenceRequestTransformerInterface $evidenceRequestTransformer)
    {
        $this->evidenceRequestTransformer = $evidenceRequestTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EvidenceRequestInterface>
     */
    public function transform(array $data): array
    {
        $evidenceRequests = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $evidenceRequests[] = $this->evidenceRequestTransformer->transform($value);
        }

        return $evidenceRequests;
    }
}
