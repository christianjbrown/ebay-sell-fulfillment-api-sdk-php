<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Error;
use ChristianBrown\EBay\SellFulfillment\Model\ErrorInterface;

use function is_array;
use function is_int;
use function is_string;

final class ErrorTransformer implements ErrorTransformerInterface
{
    private ErrorParametersTransformerInterface $errorParametersTransformer;
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(ErrorParametersTransformerInterface $errorParametersTransformer, StringsTransformerInterface $stringsTransformer)
    {
        $this->errorParametersTransformer = $errorParametersTransformer;
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorInterface
    {
        $error = new Error();

        self::applyCategory($error, $data);
        self::applyDomain($error, $data);
        self::applyErrorId($error, $data);
        $this->applyInputRefIds($error, $data);
        self::applyLongMessage($error, $data);
        self::applyMessage($error, $data);
        $this->applyOutputRefIds($error, $data);
        $this->applyParameters($error, $data);
        self::applySubdomain($error, $data);

        return $error;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategory(Error $error, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY])) {
            return;
        }
        $error->setCategory($data[self::KEY_CATEGORY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDomain(Error $error, array $data): void
    {
        if (empty($data[self::KEY_DOMAIN])) {
            return;
        }
        if (!is_string($data[self::KEY_DOMAIN])) {
            return;
        }
        $error->setDomain($data[self::KEY_DOMAIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyErrorId(Error $error, array $data): void
    {
        if (!isset($data[self::KEY_ERROR_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_ERROR_ID])) {
            return;
        }
        $error->setErrorId($data[self::KEY_ERROR_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyInputRefIds(Error $error, array $data): void
    {
        if (empty($data[self::KEY_INPUT_REF_IDS])) {
            return;
        }
        if (!is_array($data[self::KEY_INPUT_REF_IDS])) {
            return;
        }
        $error->setInputRefIds($this->stringsTransformer->transform($data[self::KEY_INPUT_REF_IDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLongMessage(Error $error, array $data): void
    {
        if (empty($data[self::KEY_LONG_MESSAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_LONG_MESSAGE])) {
            return;
        }
        $error->setLongMessage($data[self::KEY_LONG_MESSAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMessage(Error $error, array $data): void
    {
        if (empty($data[self::KEY_MESSAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_MESSAGE])) {
            return;
        }
        $error->setMessage($data[self::KEY_MESSAGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOutputRefIds(Error $error, array $data): void
    {
        if (empty($data[self::KEY_OUTPUT_REF_IDS])) {
            return;
        }
        if (!is_array($data[self::KEY_OUTPUT_REF_IDS])) {
            return;
        }
        $error->setOutputRefIds($this->stringsTransformer->transform($data[self::KEY_OUTPUT_REF_IDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyParameters(Error $error, array $data): void
    {
        if (empty($data[self::KEY_PARAMETERS])) {
            return;
        }
        if (!is_array($data[self::KEY_PARAMETERS])) {
            return;
        }
        $error->setParameters($this->errorParametersTransformer->transform($data[self::KEY_PARAMETERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubdomain(Error $error, array $data): void
    {
        if (empty($data[self::KEY_SUBDOMAIN])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBDOMAIN])) {
            return;
        }
        $error->setSubdomain($data[self::KEY_SUBDOMAIN]);
    }
}
