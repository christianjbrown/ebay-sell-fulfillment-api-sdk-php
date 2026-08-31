<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\SellFulfillment\Model\FileInfoInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class FileInfosTransformer implements FileInfosTransformerInterface
{
    private FileInfoTransformerInterface $fileInfoTransformer;

    public function __construct(FileInfoTransformerInterface $fileInfoTransformer)
    {
        $this->fileInfoTransformer = $fileInfoTransformer;
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
            if (!is_array($value)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $fileInfos[] = $this->fileInfoTransformer->transform($value);
        }

        return $fileInfos;
    }
}
