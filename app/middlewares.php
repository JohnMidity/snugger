<?php

/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */

/**
 * Load the app's middleware
 *
 * @param Slim\App $app
 */
function loadAppMiddleware($app)
{
    $container = $app->getContainer();

    $app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

    // give back the old input
    $app->add(new \App\Middleware\OldInputMiddleware($container));

    // give back a csrf generated key
    $app->add(new \App\Middleware\CsrfViewMiddleware($container));

    // add Slim CSRF
    $container['csrf'] = function ($container) {
        return new \Slim\Csrf\Guard();
    };
    $app->add($container->csrf);
}