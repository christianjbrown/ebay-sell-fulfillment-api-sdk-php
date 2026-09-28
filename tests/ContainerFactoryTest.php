<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\SellFulfillment\Tests;

use ChristianBrown\EBay\SellFulfillment\ContainerFactory;
use ChristianBrown\EBay\SellFulfillment\Registrar\ServiceRegistrarInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ContainerFactory::class)]
final class ContainerFactoryTest extends TestCase
{
    public function testBuildRunsEveryRegistrarAgainstTheSameContainer(): void
    {
        $seen = [];

        $first = self::createMock(ServiceRegistrarInterface::class);
        $first->expects(self::once())->method('register')
            ->with(self::isInstanceOf(ContainerBuilder::class))
            ->willReturnCallback(static function (ContainerBuilder $container) use (&$seen): void {
                $seen[] = $container;
            });

        $second = self::createMock(ServiceRegistrarInterface::class);
        $second->expects(self::once())->method('register')
            ->with(self::isInstanceOf(ContainerBuilder::class))
            ->willReturnCallback(static function (ContainerBuilder $container) use (&$seen): void {
                $seen[] = $container;
            });

        $factory = new ContainerFactory();
        $container = $factory->build([$first, $second]);

        self::assertSame([$container, $container], $seen);
    }

    public function testBuildWithNoRegistrarsReturnsAnEmptyContainer(): void
    {
        $factory = new ContainerFactory();

        self::assertInstanceOf(ContainerBuilder::class, $factory->build([]));
    }
}
