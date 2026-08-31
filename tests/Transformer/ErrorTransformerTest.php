<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests\Transformer;

use ChristianBrown\EBay\SellFulfillment\Model\Error;
use ChristianBrown\EBay\SellFulfillment\Model\ErrorParameterInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorParametersTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorTransformer;
use ChristianBrown\EBay\SellFulfillment\Transformer\ErrorTransformerInterface;
use ChristianBrown\EBay\SellFulfillment\Transformer\StringsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Error::class)]
#[CoversClass(ErrorTransformer::class)]
final class ErrorTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $inputRefIdsData = ['__inputRefIds__'];
        $outputRefIdsData = ['__outputRefIds__'];
        $parametersData = ['__parameters__'];

        $inputRefIds = ['alpha', 'beta'];
        $outputRefIds = ['alpha', 'beta'];
        $parameters = [self::createStub(ErrorParameterInterface::class)];

        $errorParametersTransformer = self::createStub(ErrorParametersTransformerInterface::class);
        $errorParametersTransformer->method('transform')
            ->willReturnMap(
                [
                    [$parametersData, $parameters],
                ]
            );
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')
            ->willReturnMap(
                [
                    [$inputRefIdsData, $inputRefIds],
                    [$outputRefIdsData, $outputRefIds],
                ]
            );

        $data = [
            ErrorTransformerInterface::KEY_CATEGORY => 'test-category',
            ErrorTransformerInterface::KEY_DOMAIN => 'test-domain',
            ErrorTransformerInterface::KEY_ERROR_ID => 42,
            ErrorTransformerInterface::KEY_INPUT_REF_IDS => $inputRefIdsData,
            ErrorTransformerInterface::KEY_LONG_MESSAGE => 'test-longMessage',
            ErrorTransformerInterface::KEY_MESSAGE => 'test-message',
            ErrorTransformerInterface::KEY_OUTPUT_REF_IDS => $outputRefIdsData,
            ErrorTransformerInterface::KEY_PARAMETERS => $parametersData,
            ErrorTransformerInterface::KEY_SUBDOMAIN => 'test-subdomain',
        ];

        $transformer = new ErrorTransformer($errorParametersTransformer, $stringsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-category', $actual->getCategory());
        self::assertSame('test-domain', $actual->getDomain());
        self::assertSame(42, $actual->getErrorId());
        self::assertSame($inputRefIds, $actual->getInputRefIds());
        self::assertSame('test-longMessage', $actual->getLongMessage());
        self::assertSame('test-message', $actual->getMessage());
        self::assertSame($outputRefIds, $actual->getOutputRefIds());
        self::assertSame($parameters, $actual->getParameters());
        self::assertSame('test-subdomain', $actual->getSubdomain());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformInputRefIdsNotSetCases')]
    public function testTransformInputRefIdsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getInputRefIds());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformInputRefIdsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ErrorTransformerInterface::KEY_INPUT_REF_IDS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOutputRefIdsNotSetCases')]
    public function testTransformOutputRefIdsNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getOutputRefIds());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformOutputRefIdsNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ErrorTransformerInterface::KEY_OUTPUT_REF_IDS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformParametersNotSetCases')]
    public function testTransformParametersNotSet(array $data): void
    {
        $transformer = $this->buildTransformer();

        self::assertSame([], $transformer->transform($data)->getParameters());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformParametersNotSetCases(): iterable
    {
        yield 'absent' => [[]];

        yield 'nonArray' => [[ErrorTransformerInterface::KEY_PARAMETERS => 'not-an-array']];
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformScalarFieldStatesCases')]
    public function testTransformScalarFieldStates(array $data, ?string $expectedCategory, ?string $expectedDomain, ?int $expectedErrorId, ?string $expectedLongMessage, ?string $expectedMessage, ?string $expectedSubdomain): void
    {
        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedCategory, $actual->getCategory());
        self::assertSame($expectedDomain, $actual->getDomain());
        self::assertSame($expectedErrorId, $actual->getErrorId());
        self::assertSame($expectedLongMessage, $actual->getLongMessage());
        self::assertSame($expectedMessage, $actual->getMessage());
        self::assertSame($expectedSubdomain, $actual->getSubdomain());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?int, ?string, ?string, ?string}>
     */
    public static function provideTransformScalarFieldStatesCases(): iterable
    {
        yield 'allAbsent' => [[], null, null, null, null, null, null];

        yield 'categoryWrongType' => [[ErrorTransformerInterface::KEY_CATEGORY => 42], null, null, null, null, null, null];

        yield 'domainWrongType' => [[ErrorTransformerInterface::KEY_DOMAIN => 42], null, null, null, null, null, null];

        yield 'errorIdZero' => [[ErrorTransformerInterface::KEY_ERROR_ID => 0], null, null, 0, null, null, null];

        yield 'errorIdWrongType' => [[ErrorTransformerInterface::KEY_ERROR_ID => 'not-int'], null, null, null, null, null, null];

        yield 'longMessageWrongType' => [[ErrorTransformerInterface::KEY_LONG_MESSAGE => 42], null, null, null, null, null, null];

        yield 'messageWrongType' => [[ErrorTransformerInterface::KEY_MESSAGE => 42], null, null, null, null, null, null];

        yield 'subdomainWrongType' => [[ErrorTransformerInterface::KEY_SUBDOMAIN => 42], null, null, null, null, null, null];
    }

    private function buildTransformer(): ErrorTransformer
    {
        $errorParametersTransformer = self::createStub(ErrorParametersTransformerInterface::class);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);

        return new ErrorTransformer($errorParametersTransformer, $stringsTransformer);
    }
}
