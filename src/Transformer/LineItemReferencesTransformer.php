<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\LineItemReferenceInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LineItemReferencesTransformer implements LineItemReferencesTransformerInterface
{
    private LineItemReferenceTransformerInterface $lineItemReferenceTransformer;

    public function __construct(LineItemReferenceTransformerInterface $lineItemReferenceTransformer)
    {
        $this->lineItemReferenceTransformer = $lineItemReferenceTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LineItemReferenceInterface>
     */
    public function transform(array $data): array
    {
        $lineItemReferences = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $lineItemReferences[] = $this->lineItemReferenceTransformer->transform($value);
        }

        return $lineItemReferences;
    }
}
