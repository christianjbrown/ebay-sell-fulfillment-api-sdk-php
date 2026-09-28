<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;

use function array_values;
use function count;

final class ErrorsTransformer implements ErrorsTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private ErrorTransformerInterface $errorTransformer;

    public function __construct(ErrorTransformerInterface $errorTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->errorTransformer = $errorTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ErrorInterface>
     */
    public function transform(array $data): array
    {
        $errors = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $errors[] = $this->errorTransformer->transform($value);
        }

        return $errors;
    }
}
