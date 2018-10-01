<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Middleware;

class Middleware
{

    /**
     * The container (associative array)
     *
     * @var Array
     */
    protected $container;

    /**
     * Create a new Middleware
     *
     * @param Array $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}