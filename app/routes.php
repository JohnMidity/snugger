<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

/**
 * Load the app's routes
 *
 * @param Slim\App $app
 */
function loadAppRoutes($app)
{
    $container = $app->getContainer();

    $app->get('/', HomeController::class . ':index')->setName('home');

    /* For guests not authenticated */
    $app->group('', function () {
        $this->get('/auth/signup', AuthController::class . ':signUp')
            ->setName('auth.signup');
        $this->post('/auth/signup', AuthController::class . ':postSignUp');
        $this->get('/auth/signin', AuthController::class . ':signIn')
            ->setName('auth.signin');
        $this->post('/auth/signin', AuthController::class . ':postSignIn');
    })
        ->add(new GuestMiddleware($container));

    /* For known authenticated users */
    $app->group('', function () {
        $this->get('/auth/logout', AuthController::class . ':signOut')
            ->setName('auth.signout');
        $this->get('/auth/password/change', PasswordController::class . ':getChangePassword')
            ->setName('auth.password.change');
        $this->post('/auth/password/change', PasswordController::class . ':postChangePassword');
    })
        ->add(new AuthMiddleware($container));

    /**
     * * USERS API **
     */
    $app->get('/api/users', UserController::class . ':index');
    $app->get('/api/users/{id}', UserController::class . ':get');
    $app->post('/api/users', UserController::class . ':create');
    $app->map([
        'PUT',
        'PATCH'
    ], '/api/users/{id}', UserController::class . ':update');
    $app->delete('/api/users/{id}', UserController::class . ':delete');
}