<?php

namespace State;

abstract class Middleware {
    private $following;

    protected function next(Action $action) {
        ($this->following)($action);
    }

    public function setup(\Closure $next) {
        $this->following = $next;
    }

    abstract public function handle(Action $action);
}