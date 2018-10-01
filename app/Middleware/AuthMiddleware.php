<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Middleware;

/**
 * Middleware to check authorization
 *
 * @author johnz
 *        
 */
class AuthMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {
        if (! $this->container->auth->check()) {
            /* Show a message */
            $this->container->flash->addMessage('error', 'Please sign in before doing that');

            /* Redirect the user to the home page */
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        /* continue with the next middleware */
        $response = $next($request, $response);
        return $response;
    }
}