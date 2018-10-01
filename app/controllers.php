<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */

/**
 * Load the app's controllers
 *
 * @param Slim\App $app
 */
function loadAppControllers($app)
{
    $container = $app->getContainer();

    // add Auth
    $container['auth'] = function ($container) {
        return new \App\Auth\Auth();
    };

    // add Slim Flash messages
    $container['flash'] = function () {
        return new \Slim\Flash\Messages();
    };

    /* Add the controllers to the container */
    $container['HomeController'] = function ($container) {
        return new \App\Controllers\HomeController($container);
    };

    $container['AuthController'] = function ($container) {
        return new \App\Controllers\Auth\AuthController($container);
    };

    $container['PasswordController'] = function ($container) {
        return new \App\Controllers\Auth\PasswordController($container);
    };
}