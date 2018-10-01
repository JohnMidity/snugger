<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Controllers;

class Controller
{

    /**
     * The container (associative array)
     *
     * @var Array
     */
    protected $container;

    /**
     * Create a new controller
     *
     * @param Array $container
     */
    public function __construct($container)
    {
        /* Store the $container, which is added by dependency injection, in a field */
        $this->container = $container;
    }

    /**
     * Attempt to get the property from the container
     *
     * @param string $property
     * @return unknown
     */
    public function __get(string $property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}