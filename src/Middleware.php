<?php

namespace State;

abstract class Middleware {
    private $dispatcher;
    private $following;

    protected function dispatch(Action $action) {
        $this->dispatcher->dispatch($action);
    }

    protected function next(Action $action) {
        call_user_func($this->following, $action);
    }

    public function setup(Dispatcher $dispatcher, Action $action) {
        $this->dispatcher = $dispatcher;
        $this->following = $next;
    }

    abstract public function handle(Action $action);
}