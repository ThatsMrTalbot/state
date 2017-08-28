<?php

namespace State;

class Dispatcher {
    private $instances = [];

    public function list() : array {
        return $this->instances;
    }

    public function register(State ...$classes) {
        foreach ($classes as $class) {
            $name = get_class($class);
            $this->instances[$name] = $class;
        }
    }

    public function dispatch(Action $action) {
        foreach ($this->instances as $key => $instance) {
            $this->instances[$key] = $key::reduce($action, $instance);
        }
    }
}
