<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppointmentDetails;
use ChristianBrown\EBay\SellFulfillment\Model\AppointmentDetailsInterface;

use function is_string;

final class AppointmentDetailsTransformer implements AppointmentDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppointmentDetailsInterface
    {
        $appointmentDetails = new AppointmentDetails();

        self::applyAppointmentEndTime($appointmentDetails, $data);
        self::applyAppointmentStartTime($appointmentDetails, $data);
        self::applyAppointmentStatus($appointmentDetails, $data);
        self::applyAppointmentType($appointmentDetails, $data);
        self::applyAppointmentWindow($appointmentDetails, $data);
        self::applyServiceProviderAppointmentDate($appointmentDetails, $data);

        return $appointmentDetails;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppointmentEndTime(AppointmentDetails $appointmentDetails, array $data): void
    {
        if (empty($data[self::KEY_APPOINTMENT_END_TIME])) {
            return;
        }
        if (!is_string($data[self::KEY_APPOINTMENT_END_TIME])) {
            return;
        }
        $appointmentDetails->setAppointmentEndTime($data[self::KEY_APPOINTMENT_END_TIME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppointmentStartTime(AppointmentDetails $appointmentDetails, array $data): void
    {
        if (empty($data[self::KEY_APPOINTMENT_START_TIME])) {
            return;
        }
        if (!is_string($data[self::KEY_APPOINTMENT_START_TIME])) {
            return;
        }
        $appointmentDetails->setAppointmentStartTime($data[self::KEY_APPOINTMENT_START_TIME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppointmentStatus(AppointmentDetails $appointmentDetails, array $data): void
    {
        if (empty($data[self::KEY_APPOINTMENT_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_APPOINTMENT_STATUS])) {
            return;
        }
        $appointmentDetails->setAppointmentStatus($data[self::KEY_APPOINTMENT_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppointmentType(AppointmentDetails $appointmentDetails, array $data): void
    {
        if (empty($data[self::KEY_APPOINTMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_APPOINTMENT_TYPE])) {
            return;
        }
        $appointmentDetails->setAppointmentType($data[self::KEY_APPOINTMENT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppointmentWindow(AppointmentDetails $appointmentDetails, array $data): void
    {
        if (empty($data[self::KEY_APPOINTMENT_WINDOW])) {
            return;
        }
        if (!is_string($data[self::KEY_APPOINTMENT_WINDOW])) {
            return;
        }
        $appointmentDetails->setAppointmentWindow($data[self::KEY_APPOINTMENT_WINDOW]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyServiceProviderAppointmentDate(AppointmentDetails $appointmentDetails, array $data): void
    {
        if (empty($data[self::KEY_SERVICE_PROVIDER_APPOINTMENT_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_SERVICE_PROVIDER_APPOINTMENT_DATE])) {
            return;
        }
        $appointmentDetails->setServiceProviderAppointmentDate($data[self::KEY_SERVICE_PROVIDER_APPOINTMENT_DATE]);
    }
}
