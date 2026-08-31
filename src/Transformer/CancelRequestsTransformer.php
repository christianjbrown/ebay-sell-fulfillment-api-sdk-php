<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\CancelRequestInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class CancelRequestsTransformer implements CancelRequestsTransformerInterface
{
    private CancelRequestTransformerInterface $cancelRequestTransformer;

    public function __construct(CancelRequestTransformerInterface $cancelRequestTransformer)
    {
        $this->cancelRequestTransformer = $cancelRequestTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $cancelRequests[] = $this->cancelRequestTransformer->transform($value);
        }

        return $cancelRequests;
    }
}
