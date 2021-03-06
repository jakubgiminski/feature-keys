<?php
declare(strict_types=1);

namespace FeatureKeys\Tests\FeatureOverride;

use FeatureKeys\FeatureOverride\FeatureOverrideContainerHydrator;
use FeatureKeys\Tests\StarWars\FeatureAccessOverrideConfig;
use FeatureKeys\Tests\StarWars\FeatureOverride\FeatureAccessOverrideContainerFactory;
use FeatureKeys\Tests\StarWars\FeatureOverride\FeatureAccessOverrideFactory;
use FeatureKeys\Tests\StarWars\FeatureOverride\Parameters\CountryId;
use FeatureKeys\Tests\StarWars\FeatureOverride\Parameters\PlayerId;
use FeatureKeys\Tests\StarWars\FeatureOverride\Parameters\TeamId;
use FeatureKeys\Tests\StarWars\FeatureOverride\Parameters\UniverseId;
use PHPUnit\Framework\TestCase;

class FeatureOverrideContainerHydratorTest extends TestCase
{
    private $container;

    public function setUp(): void
    {
        $containerFactory = new FeatureAccessOverrideContainerFactory(
            new FeatureAccessOverrideFactory(
                new PlayerId('darkslayer097'),
                new TeamId('GoVirtusPro'),
                new UniverseId('Tatooine'),
                new CountryId('polska')
            )
        );
        $this->container = $containerFactory->createFromConfig(new FeatureAccessOverrideConfig());
    }

    public function testCanUnsetAfterFirstElement(): void
    {
        $serializedContainer = $this->container->serialize();
        $firstElement = reset($serializedContainer);
        $hydratedContainer = FeatureOverrideContainerHydrator::unsetAfter($this->container, $firstElement::getName());
        $serializedHydratedContainer = $hydratedContainer->serialize();
        self::assertCount(1, $serializedHydratedContainer);
    }

    public function testCanUnsetAfterLastElement(): void
    {
        $serializedContainer = $this->container->serialize();
        $lastElement = end($serializedContainer);
        $hydratedContainer = FeatureOverrideContainerHydrator::unsetAfter($this->container, $lastElement::getName());
        $serializedHydratedContainer = $hydratedContainer->serialize();
        self::assertCount(count($serializedContainer), $serializedHydratedContainer);
    }
}
