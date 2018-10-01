<?php
use App\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNameToUsersTable extends Migration
{

    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
    

