<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

class PasswordController extends Controller
{

    /**
     * Change the password view
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function getChangePassword(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        return $this->view->render($response, 'auth/password/change.twig');
    }

    /**
     * Handle password change request
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function postChangePassword(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        /* Validate the new password */
        $validation = $this->validator->validate($request, [
            'password_old' => Validator::noWhitespace()->notEmpty()
                ->matchesPassword($this->auth->user()->password),
            'password' => Validator::noWhitespace()->notEmpty()
        ]);

        /* retry on validation error */
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        }

        /* change the password */
        $this->auth->user()->setPassword($request->getParam('password'));

        /* Show a success message */
        $this->flash->addMessage('success', 'Your password has been updated');

        /* redirect to the home page */
        return $response->withRedirect($this->router->pathFor('home'));
    }
}