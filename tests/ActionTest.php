<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use State\Action;

/**
 * @covers Action
 */
final class ActionTest extends TestCase
{
    public function testActionTypeCanBeTested() {
        $valid = new class extends Action {};
        $invalid = new class extends Action {};

        $this->assertInstanceOf(
            Action::class,
            $valid
        );
        
        $this->assertInstanceOf(
            Action::class,
            $invalid
        );

        $this->assertTrue(
            $valid::is($valid)
        );

        $this->assertFalse(
            $valid::is($invalid)
        );
    }
}