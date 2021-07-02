<?php

namespace Ashraam\IpaidthatPhp\Entity;

abstract class AbstractEntity
{
    public function __construct($attributes = null)
    {
        if ($attributes === null) {
            return;
        }

        if (\is_object($attributes)) {
            $attributes = \get_object_vars($attributes);
        }

        $this->build($attributes);
    }

    public function build(array $attributes): void
    {
        foreach ($attributes as $property => $value) {
            if (\property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    public function toArray(): array
    {
        $settings = [];
        $called = static::class;

        $reflection = new \ReflectionClass($called);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $prop = $property->getName();
            if (isset($this->$prop) && $property->class == $called) {
                $settings[$prop] = $this->$prop;
            }
        }

        return $settings;
    }
}
