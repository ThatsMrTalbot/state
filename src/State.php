<?php

namespace State;

abstract class State {
    public function mutate(array $mutation) : self {
        $instance = clone $this;

        foreach ($mutation as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            } else {
                throw new MissingPropertyException("Property '$key' does not exist in state");
            }
        }

        return $instance;
    }

    abstract public static function reduce(Action $action, self $state) : self;
}
