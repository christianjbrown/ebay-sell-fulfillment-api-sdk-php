<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;

use function array_values;
use function count;

final class FileInfosTransformer implements FileInfosTransformerInterface
{
    private ArrayShapeGuardInterface $arrayShapeGuard;
    private FileInfoTransformerInterface $fileInfoTransformer;

    public function __construct(FileInfoTransformerInterface $fileInfoTransformer, ArrayShapeGuardInterface $arrayShapeGuard)
    {
        $this->fileInfoTransformer = $fileInfoTransformer;
        $this->arrayShapeGuard = $arrayShapeGuard;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, FileInfoInterface>
     */
    public function transform(array $data): array
    {
        $fileInfos = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $value = $values[$i];
            $this->arrayShapeGuard->assertArray($value, self::ARRAY_NAME);
            $fileInfos[] = $this->fileInfoTransformer->transform($value);
        }

        return $fileInfos;
    }
}
