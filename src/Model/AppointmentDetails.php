<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Model;

final class AppointmentDetails implements AppointmentDetailsInterface
{
    private ?string $appointmentEndTime = null;
    private ?string $appointmentStartTime = null;
    private ?string $appointmentStatus = null;
    private ?string $appointmentType = null;
    private ?string $appointmentWindow = null;
    private ?string $serviceProviderAppointmentDate = null;

    public function getAppointmentEndTime(): ?string
    {
        return $this->appointmentEndTime;
    }

    public function getAppointmentStartTime(): ?string
    {
        return $this->appointmentStartTime;
    }

    public function getAppointmentStatus(): ?string
    {
        return $this->appointmentStatus;
    }

    public function getAppointmentType(): ?string
    {
        return $this->appointmentType;
    }

    public function getAppointmentWindow(): ?string
    {
        return $this->appointmentWindow;
    }

    public function getServiceProviderAppointmentDate(): ?string
    {
        return $this->serviceProviderAppointmentDate;
    }

    public function setAppointmentEndTime(?string $value): AppointmentDetailsInterface
    {
        $this->appointmentEndTime = $value;

        return $this;
    }

    public function setAppointmentStartTime(?string $value): AppointmentDetailsInterface
    {
        $this->appointmentStartTime = $value;

        return $this;
    }

    public function setAppointmentStatus(?string $value): AppointmentDetailsInterface
    {
        $this->appointmentStatus = $value;

        return $this;
    }

    public function setAppointmentType(?string $value): AppointmentDetailsInterface
    {
        $this->appointmentType = $value;

        return $this;
    }

    public function setAppointmentWindow(?string $value): AppointmentDetailsInterface
    {
        $this->appointmentWindow = $value;

        return $this;
    }

    public function setServiceProviderAppointmentDate(?string $value): AppointmentDetailsInterface
    {
        $this->serviceProviderAppointmentDate = $value;

        return $this;
    }
}
