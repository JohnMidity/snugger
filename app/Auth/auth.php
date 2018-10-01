<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Auth;

use App\Models\User;

/**
 * Authentication
 */
class Auth
{

    /**
     * Use the session to find the User object
     *
     * @return User
     */
    public function user()
    {
        if (isset($_SESSION['user'])) {
            return User::find($_SESSION['user']);
        }
    }

    /**
     * verify whether the user is logged in
     *
     * @return boolean
     */
    public function check()
    {
        return isset($_SESSION['user']);
    }

    /**
     * try to log in
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function attempt(string $email, string $password)
    {
        // get the data of the attempted user
        $user = User::where('email', $email)->first();

        // check if the user exists
        if (! $user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }

    /**
     * Destroy the user's session
     */
    public function logout()
    {
        unset($_SESSION['user']);
    }
}