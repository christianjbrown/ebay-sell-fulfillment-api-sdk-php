<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

interface AppointmentDetailsInterface
{
    public function getAppointmentEndTime(): ?string;

    public function getAppointmentStartTime(): ?string;

    public function getAppointmentStatus(): ?string;

    public function getAppointmentType(): ?string;

    public function getAppointmentWindow(): ?string;

    public function getServiceProviderAppointmentDate(): ?string;

    public function setAppointmentEndTime(?string $value): self;

    public function setAppointmentStartTime(?string $value): self;

    public function setAppointmentStatus(?string $value): self;

    public function setAppointmentType(?string $value): self;

    public function setAppointmentWindow(?string $value): self;

    public function setServiceProviderAppointmentDate(?string $value): self;
}
