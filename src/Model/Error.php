<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class Error implements ErrorInterface
{
    private ?string $category = null;
    private ?string $domain = null;
    private ?int $errorId = null;

    /**
     * @var array<int, string>
     */
    private array $inputRefIds = [];
    private ?string $longMessage = null;
    private ?string $message = null;

    /**
     * @var array<int, string>
     */
    private array $outputRefIds = [];

    /**
     * @var array<int, ErrorParameterInterface>
     */
    private array $parameters = [];
    private ?string $subdomain = null;

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function getErrorId(): ?int
    {
        return $this->errorId;
    }

    /**
     * @return array<int, string>
     */
    public function getInputRefIds(): array
    {
        return $this->inputRefIds;
    }

    public function getLongMessage(): ?string
    {
        return $this->longMessage;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return array<int, string>
     */
    public function getOutputRefIds(): array
    {
        return $this->outputRefIds;
    }

    /**
     * @return array<int, ErrorParameterInterface>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getSubdomain(): ?string
    {
        return $this->subdomain;
    }

    public function setCategory(?string $value): ErrorInterface
    {
        $this->category = $value;

        return $this;
    }

    public function setDomain(?string $value): ErrorInterface
    {
        $this->domain = $value;

        return $this;
    }

    public function setErrorId(?int $value): ErrorInterface
    {
        $this->errorId = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setInputRefIds(array $value): ErrorInterface
    {
        $this->inputRefIds = $value;

        return $this;
    }

    public function setLongMessage(?string $value): ErrorInterface
    {
        $this->longMessage = $value;

        return $this;
    }

    public function setMessage(?string $value): ErrorInterface
    {
        $this->message = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setOutputRefIds(array $value): ErrorInterface
    {
        $this->outputRefIds = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorParameterInterface> $value
     */
    public function setParameters(array $value): ErrorInterface
    {
        $this->parameters = $value;

        return $this;
    }

    public function setSubdomain(?string $value): ErrorInterface
    {
        $this->subdomain = $value;

        return $this;
    }
}
