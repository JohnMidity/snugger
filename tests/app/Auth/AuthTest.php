<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use App\Auth\Auth;
use App\Models\User;
use Phinx\Wrapper\TextWrapper;

final class AuthTest extends TestCase
{

    /**
     * Prepare the database before testing
     */
    public static function setUpBeforeClass()
    {
        $phinx = require __DIR__ . '/../../../vendor/robmorgan/phinx/app/phinx.php';
        $wrap = new TextWrapper($phinx, [
            'configuration' => __DIR__ . '/../../../phinx.php',
            'parser' => 'php'
        ]);
        $wrap->getMigrate();
    }

    /**
     * Rollback the database after this test
     */
    public static function tearDownAfterClass()
    {
        $phinx = require __DIR__ . '/../../../vendor/robmorgan/phinx/app/phinx.php';
        $wrap = new TextWrapper($phinx, [
            'configuration' => __DIR__ . '/../../../phinx.php',
            'parser' => 'php'
        ]);
        $wrap->getRollback(null, 0);
    }

    public function testCheck_UserIsNotLoggedIn()
    {
        $a = new Auth();
        $this->assertFalse($a->check());
    }

    public function testAuthCanFindUser(): void
    {
        $user = User::create([
            'email' => 'test@test.test',
            'name' => 'testname',
            'password' => password_hash('test', PASSWORD_DEFAULT)
        ]);

        $a = new Auth();
        $this->assertInstanceOf(Auth::class, $a);

        $_SESSION['user'] = $user->id;

        $this->assertNotEmpty($a->user());

        $this->assertInstanceOf(User::class, $a->user());
    }

    public function testCheck_UserIsLoggedIn()
    {
        $a = new Auth();
        $this->assertInstanceOf(Auth::class, $a);
        $this->assertTrue($a->check());
    }

    public function testAttemptLoginFails()
    {
        $a = new Auth();
        $this->assertInstanceOf(Auth::class, $a);
        $this->assertFalse($a->attempt('emailaddressiswrong', 'test'));
        $this->assertFalse($a->attempt('test@test.test', 'passwordiswrong'));
        $this->assertFalse($a->attempt('emailaddressiswrong', 'passwordiswrong'));
        $this->asserttrue($a->attempt('test@test.test', 'test'));
    }

    public function testLoginLogOut()
    {
        $a = new Auth();
        $this->assertInstanceOf(Auth::class, $a);

        /* login */
        $this->assertTrue($a->attempt('test@test.test', 'test'));

        $this->assertTrue($a->check());

        $a->logout();
        $this->assertFalse($a->check());
    }
}

