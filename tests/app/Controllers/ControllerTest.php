<?php
use PHPUnit\Framework\TestCase;

use App\Controllers\Controller;

/**
 * Controller test case.
 */
class ControllerTest extends TestCase
{

    /**
     *
     * @return \App\Controllers\Controller
     */
    public function testControllerCanBeCreated()
    {
        $container = (object) [
            'item1' => 'value1',
            'item2' => 'value2'
        ];
        $controller = new Controller($container);
        $this->assertInstanceOf(Controller::class, $controller);

        return $controller;
    }

    /**
     *
     * @depends testControllerCanBeCreated
     * @param Controller $controller
     */
    public function testGetReturnsExistingValue($controller)
    {
        $this->assertEquals("value1", $controller->item1);
        $this->assertEquals("value2", $controller->item2);
    }
}

