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

    public function testCanBind() {
        // Arrange
        $dispatcher = new Dispatcher();
        $state = new class extends State {
            public static function reduce(Action $action, State $state) : State {
                return $state;
            }
        };
        
        $dispatcher->register($state);
        
        // Act
        $dispatcher->bind(get_class($state), $binding);

        // Assert
        $this->assertEquals($state, $binding);
    }

    public function testBindGetsUpdates() {
        // Arrange
        $dispatcher = new Dispatcher();
        $action = new class extends Action {};            
        $state = new class extends State {
            public $mutations = 0;

            public static function reduce(Action $action, State $state) : State {
                return $state->mutate(["mutations" => $state->mutations + 1]);
            }
        };
        
        $dispatcher->register($state);
        $dispatcher->bind(get_class($state), $binding);
        
        // Act
        $dispatcher->dispatch($action);        

        // Assert
        $this->assertEquals(1, $binding->mutations);
    }
}