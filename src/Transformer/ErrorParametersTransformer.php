<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameterInterface;

use function array_values;
use function count;

final class ErrorParametersTransformer implements ErrorParametersTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private ErrorParameterTransformerInterface $errorParameterTransformer;

    public function __construct(ErrorParameterTransformerInterface $errorParameterTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->errorParameterTransformer = $errorParameterTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ErrorParameterInterface>
     */
    public function transform(array $data): array
    {
        $errorParameters = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $errorParameters[] = $this->errorParameterTransformer->transform($value);
        }

        return $errorParameters;
    }
}
