<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
use Respect\Validation\Validator;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app/controllers.php';
require_once __DIR__ . '/../app/routes.php';
require_once __DIR__ . '/../app/middlewares.php';

/* Load the environment variables */
try {
    if (isset($_ENV['APP_ENV'])) {
        (new Dotenv\Dotenv(__DIR__ . '/../', '.env.' . $_ENV['APP_ENV']))->load();
    } else {
        (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
    }
} catch (Dotenv\Exception\InvalidPathException $e) {}

/* Setup the app */
$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',

        'app' => [
            'name' => getenv('APP_NAME')
        ],

        'views' => [
            'cache' => getenv('VIEW_CACHE_DISABLED') === 'true' ? false : __DIR__ . '/../storage/views'
        ],
        'database' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD')
        ]
    ]
]);

$container = $app->getContainer();

// set up eloquent ORM
$config = $container['settings']['database'];
$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection(array_merge($config, [
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci'
]));
$capsule->bootEloquent();
$capsule->setAsGlobal();
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['validator'] = function ($container) {
    return new App\Validation\Validator();
};

// setup validation rules
Validator::with('App\\Validation\\Rules\\');

// add views to the application
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../storage/views', [
        'cache' => $container->settings['views']['cache']
    ]);

    $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));

    // let the view have access to auth controller
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user()
    ]);

    // let the view have access to flash messages
    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

loadAppRoutes($app);
loadAppMiddleware($app);
loadAppControllers($app);
