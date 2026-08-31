<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\PostSaleAuthenticationProgram;
use ChristianBrown\EBay\SellFulfillment\Transformer\PostSaleAuthenticationProgramTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\PostSaleAuthenticationProgramTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostSaleAuthenticationProgram::class)]
#[CoversClass(PostSaleAuthenticationProgramTransformer::class)]
final class PostSaleAuthenticationProgramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PostSaleAuthenticationProgramTransformerInterface::KEY_OUTCOME_REASON => 'test-outcomeReason',
            PostSaleAuthenticationProgramTransformerInterface::KEY_STATUS => 'test-status',
        ];

        $transformer = new PostSaleAuthenticationProgramTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-outcomeReason', $actual->getOutcomeReason());
        self::assertSame('test-status', $actual->getStatus());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedOutcomeReason, ?string $expectedStatus): void
    {
        $transformer = new PostSaleAuthenticationProgramTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedOutcomeReason, $actual->getOutcomeReason());
        self::assertSame($expectedStatus, $actual->getStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null];

        yield 'outcomeReasonWrongType' => [[PostSaleAuthenticationProgramTransformerInterface::KEY_OUTCOME_REASON => 42], null, null];

        yield 'statusWrongType' => [[PostSaleAuthenticationProgramTransformerInterface::KEY_STATUS => 42], null, null];
    }
}
