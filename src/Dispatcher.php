<?php

namespace State;

class Dispatcher {
    private $instances = [];
    private $bindings = [];

    private function publish($state) {
        $name = get_class($state);

        if (!isset($this->bindings[$name])) {
            return;
        }

        foreach ($this->bindings[$name] as &$binding) {
            $binding = $this->instances[$name];
        }
    }

    public function bind(string $class, &$bind) {
        if (!isset($this->instances)) {
            throw new StateNotRegisteredException("State $class has not been registered");
        }

        $this->bindings[$class][] = &$bind;
        $bind = $this->instances[$class];
    }

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
            $mutated = $key::reduce($action, $instance);

            $this->instances[$key] = $mutated;
            $this->publish($mutated);
        }
    }
}
