<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use State\Action;
use State\State;

/**
 * @covers State
 */
final class StateTest extends TestCase
{
    public function testStateCanMutateProperty() {
        // Arrange
        $original = new class extends State {
            public $prop;

            public static function reduce(Action $action, State $state) : State {
                return $state;
            }
        };

        // Act
        $mutated = $original->mutate(['prop' => 5]);

        // Assert
        $this->assertEquals(5, $mutated->prop);
        $this->assertNotEquals(5, $original->prop);
    }

    /**
     * @expectedException State\MissingPropertyException
     */
    public function testStateCanNotMutateMissingProperty() {
        // Arrange
        $original = new class extends State {
            public static function reduce(Action $action, State $state) : State {
                return $state;
            }
        };

        // Act
        $mutated = $original->mutate(['prop' => 5]);
    }
}