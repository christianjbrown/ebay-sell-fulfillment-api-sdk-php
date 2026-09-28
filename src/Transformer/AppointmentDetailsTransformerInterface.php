<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppointmentDetailsInterface;

interface AppointmentDetailsTransformerInterface
{
    public const string KEY_APPOINTMENT_END_TIME = 'appointmentEndTime';
    public const string KEY_APPOINTMENT_START_TIME = 'appointmentStartTime';
    public const string KEY_APPOINTMENT_STATUS = 'appointmentStatus';
    public const string KEY_APPOINTMENT_TYPE = 'appointmentType';
    public const string KEY_APPOINTMENT_WINDOW = 'appointmentWindow';
    public const string KEY_SERVICE_PROVIDER_APPOINTMENT_DATE = 'serviceProviderAppointmentDate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppointmentDetailsInterface;
}
