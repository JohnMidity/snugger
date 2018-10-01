<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Responsible for the home page
 *
 * @author johnz
 */
class HomeController extends Controller
{

    /**
     * Respond to GET on the homepage
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface the rendered view
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        return $this->view->render($response, 'home.twig');
    }
}