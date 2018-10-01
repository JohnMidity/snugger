<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

/**
 * Controls registering, authenticating, sign out
 */
class AuthController extends Controller
{

    /**
     * Show user registration view
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function signUp(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    /**
     * Handle sign up submit
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function postSignUp(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        $validation = $this->validator->validate($request, [
            'email' => Validator::noWhitespace()->notEmpty()
                ->emailAvailable(),
            'name' => Validator::notEmpty()->alpha(),
            'password' => Validator::noWhitespace()->notEmpty()
        ]);

        /* redirect to signup if validation failed */
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        /* Create a new user */
        $user = User::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
        ]);

        /* Show a message */
        $this->flash->addMessage('info', 'You have been signed up');

        /* sign in the new user */
        $this->auth->attempt($user->email, $request->getParam('password'));

        /* Redirect to home */
        return $response->withRedirect($this->router->pathFor('home'));
    }

    /**
     * Sign out
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function signOut(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        /* Log out */
        $this->auth->logout();

        /* Show a message */
        $this->flash->addMessage('error', 'You have been signed out');

        /* Redirect to home */
        return $response->withRedirect($this->router->pathFor('home'));
    }

    /**
     * Show user sign in form
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function signIn(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }

    /**
     * Handle sign in submit
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function postSignIn(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        // use the attempt class
        $auth = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));

        if (! $auth) {
            // flash message
            $this->flash->addMessage('error', 'Could not sign you in with those details');

            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        // flash message
        $this->flash->addMessage('success', 'Successfully signed in');
        return $response->withRedirect($this->router->pathFor('home'));
    }
}