<?php

namespace State;

abstract class Action {
    public static function is(Action $action) : bool {
        $class = get_called_class();
        return is_a($action, $class);
    }
}