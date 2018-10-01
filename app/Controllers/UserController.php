<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */

/* THIS IS AN API EXAMPLE */
namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/* TODO: Use authentication */
/* TODO: Use Respect validation */

/**
 * An example API communicating in JSON
 *
 * @todo TODO use something else as example, not the user.
 *      
 * @author johnz
 *        
 */
class UserController extends Controller
{

    /**
     * get all records
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        return $response->withJson(User::get());
    }

    /**
     * get one user
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     */
    public function get(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        $user = User::find($args['id']);

        if ($user) {
            return $response->withJson($user);
        } else {
            return $response->withStatus(400)->withJson([
                'errorInfo' => [
                    '',
                    - 1,
                    'record does not exist'
                ]
            ]);
        }
    }

    /**
     * Save a user and respond with the full record
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        /* Get the parameters explicitly one by one */
        $username = $request->getParam('username');
        $email = $request->getParam('email');

        // Do validation here

        // Save the user
        $user = new User();
        $user->username = $username;
        $user->email = $email;

        try {
            $user->save();
        } catch (QueryException $e) {
            return $response->withStatus(400)->withJson([
                'errorInfo' => $e->errorInfo
            ]);
        }

        // Respond with the full record
        return $response->withJson($user);
    }

    /**
     * Update a user record
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        /* the fields that can be updated */
        $modelFields = [
            'username',
            'email',
            'first_name',
            'last_name'
        ];

        $params = $request->getParams();

        $newValues = [];

        foreach ($params as $fieldName => $fieldValue) {
            if (in_array($fieldName, $modelFields)) {
                /* this is a valid field name */
                $newValues[$fieldName] = $fieldValue;
            } else {
                /* this is an invalid field */
                return $response->withStatus(500)->withJson([
                    'errorInfo' => [
                        '',
                        - 1,
                        'invalid field ' . $fieldName
                    ]
                ]);
            }
        }

        try {
            /* Now update the record */
            $user = User::find($args['id']);
            $user->update($newValues);
        } catch (QueryException $e) {
            return $response->withStatus(400)->withJson([
                'errorInfo' => $e->errorInfo
            ]);
        }

        // Respond with the full record
        return $response->withJson($user);
    }

    /**
     * Delete a user record
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, Array $args)
    {
        try {
            /* Now update the record */
            $user = User::find($args['id']);
            if ($user) {
                $user->delete();
            } else {
                return $response->withStatus(400)->withJson([
                    'errorInfo' => [
                        '',
                        - 1,
                        'record does not exist'
                    ]
                ]);
            }
        } catch (QueryException $e) {
            return $response->withStatus(400)->withJson([
                'errorInfo' => $e->errorInfo
            ]);
        }
    }
}
