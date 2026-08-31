<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface ErrorInterface
{
    public function getCategory(): ?string;

    public function getDomain(): ?string;

    public function getErrorId(): ?int;

    /**
     * @return array<int, string>
     */
    public function getInputRefIds(): array;

    public function getLongMessage(): ?string;

    public function getMessage(): ?string;

    /**
     * @return array<int, string>
     */
    public function getOutputRefIds(): array;

    /**
     * @return array<int, ErrorParameterInterface>
     */
    public function getParameters(): array;

    public function getSubdomain(): ?string;

    public function setCategory(?string $value): self;

    public function setDomain(?string $value): self;

    public function setErrorId(?int $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setInputRefIds(array $value): self;

    public function setLongMessage(?string $value): self;

    public function setMessage(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setOutputRefIds(array $value): self;

    /**
     * @param array<int, ErrorParameterInterface> $value
     */
    public function setParameters(array $value): self;

    public function setSubdomain(?string $value): self;
}
