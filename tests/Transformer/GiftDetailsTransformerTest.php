<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\GiftDetails;
use ChristianBrown\EBay\SellFulfillment\Transformer\GiftDetailsTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\GiftDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(GiftDetails::class)]
#[CoversClass(GiftDetailsTransformer::class)]
final class GiftDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            GiftDetailsTransformerInterface::KEY_MESSAGE => 'test-message',
            GiftDetailsTransformerInterface::KEY_RECIPIENT_EMAIL => 'test-recipientEmail',
            GiftDetailsTransformerInterface::KEY_SENDER_NAME => 'test-senderName',
        ];

        $transformer = new GiftDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-message', $actual->getMessage());
        self::assertSame('test-recipientEmail', $actual->getRecipientEmail());
        self::assertSame('test-senderName', $actual->getSenderName());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedMessage, ?string $expectedRecipientEmail, ?string $expectedSenderName): void
    {
        $transformer = new GiftDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedMessage, $actual->getMessage());
        self::assertSame($expectedRecipientEmail, $actual->getRecipientEmail());
        self::assertSame($expectedSenderName, $actual->getSenderName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null];

        yield 'messageWrongType' => [[GiftDetailsTransformerInterface::KEY_MESSAGE => 42], null, null, null];

        yield 'recipientEmailWrongType' => [[GiftDetailsTransformerInterface::KEY_RECIPIENT_EMAIL => 42], null, null, null];

        yield 'senderNameWrongType' => [[GiftDetailsTransformerInterface::KEY_SENDER_NAME => 42], null, null, null];
    }
}
