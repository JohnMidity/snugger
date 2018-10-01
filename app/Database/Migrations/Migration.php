<?php
/**
 * Snugger - A PHP boilerplate based on Slim
 *
 * @package  snugger
 * @author   John Zandbergen <john@office4.in>
 */
namespace app\Database\Migrations;

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Migration extends AbstractMigration
{

    protected $schema;

    public function init()
    {
        $this->schema = (new Capsule())->schema();
    }
}

