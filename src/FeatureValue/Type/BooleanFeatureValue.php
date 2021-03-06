<?php
declare(strict_types=1);

namespace FeatureKeys\FeatureValue\Type;

use FeatureKeys\FeatureValue\FeatureValue;

abstract class BooleanFeatureValue extends FeatureValue
{
    protected function __construct(bool $value)
    {
        parent::__construct($value);
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function setValue(bool $value): void
    {
        $this->value = $value;
    }
}
