<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Middleware;

class OldInputMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {
        /* Add our previous values */
        $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);

        /* Store all our current field-values in the session */
        $_SESSION['old'] = $request->getParams();

        /* continue with the next middleware */
        $response = $next($request, $response);
        return $response;
    }
}