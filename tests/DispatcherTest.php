<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use State\{State, Action, Dispatcher};


/**
 * @covers Dispatcher
 */
final class DispatcherTest extends TestCase {
    public function testCanRegisterState() {
        // Arrange
        $dispatcher = new Dispatcher();
        $state = new class extends State {
            public static function reduce(Action $action, State $state) : State {
                return $state;
            }
        };

        // Act
        $dispatcher->register($state);

        // Assert
        $this->assertContains($state, $dispatcher->list());
    }

    public function testCanDispatchAction() {
        // Arrange
        $dispatcher = new Dispatcher();
        $action = new class extends Action {};
        $state = new class extends State {
            public static $args;

            public static function reduce(Action $action, State $state) : State {
                self::$args = func_get_args();
                return $state;
            }
        };

        // Act
        $dispatcher->register($state);
        $dispatcher->dispatch($action);

        // Assert
        $this->assertEquals([$action, $state], $state::$args);
    }
}