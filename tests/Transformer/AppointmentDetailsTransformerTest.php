<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\AppointmentDetails;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppointmentDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\AppointmentDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppointmentDetails::class)]
#[CoversClass(AppointmentDetailsTransformer::class)]
final class AppointmentDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_END_TIME => 'test-appointmentEndTime',
            AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_START_TIME => 'test-appointmentStartTime',
            AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_STATUS => 'test-appointmentStatus',
            AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_TYPE => 'test-appointmentType',
            AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_WINDOW => 'test-appointmentWindow',
            AppointmentDetailsTransformerInterface::KEY_SERVICE_PROVIDER_APPOINTMENT_DATE => 'test-serviceProviderAppointmentDate',
        ];

        $transformer = new AppointmentDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-appointmentEndTime', $actual->getAppointmentEndTime());
        self::assertSame('test-appointmentStartTime', $actual->getAppointmentStartTime());
        self::assertSame('test-appointmentStatus', $actual->getAppointmentStatus());
        self::assertSame('test-appointmentType', $actual->getAppointmentType());
        self::assertSame('test-appointmentWindow', $actual->getAppointmentWindow());
        self::assertSame('test-serviceProviderAppointmentDate', $actual->getServiceProviderAppointmentDate());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data): void
    {
        $transformer = new AppointmentDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getAppointmentEndTime());
        self::assertNull($actual->getAppointmentStartTime());
        self::assertNull($actual->getAppointmentStatus());
        self::assertNull($actual->getAppointmentType());
        self::assertNull($actual->getAppointmentWindow());
        self::assertNull($actual->getServiceProviderAppointmentDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[]];

        yield 'appointmentEndTimeWrongType' => [[AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_END_TIME => 42]];

        yield 'appointmentStartTimeWrongType' => [[AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_START_TIME => 42]];

        yield 'appointmentStatusWrongType' => [[AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_STATUS => 42]];

        yield 'appointmentTypeWrongType' => [[AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_TYPE => 42]];

        yield 'appointmentWindowWrongType' => [[AppointmentDetailsTransformerInterface::KEY_APPOINTMENT_WINDOW => 42]];

        yield 'serviceProviderAppointmentDateWrongType' => [[AppointmentDetailsTransformerInterface::KEY_SERVICE_PROVIDER_APPOINTMENT_DATE => 42]];
    }
}
