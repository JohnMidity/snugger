<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailAvailableException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already taken.'
        ]
    ];
}