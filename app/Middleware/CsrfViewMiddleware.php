<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Middleware;

class CsrfViewMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
				<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" id="' . $this->container->csrf->getTokenNameKey() . '" class="form-control" value="' . $this->container->csrf->getTokenName() . '">
				<input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" id="' . $this->container->csrf->getTokenValueKey() . '" class="form-control" value="' . $this->container->csrf->getTokenValue() . '">
			'
        ]);

        /* continue with the next middleware */
        $response = $next($request, $response);
        return $response;
    }
}