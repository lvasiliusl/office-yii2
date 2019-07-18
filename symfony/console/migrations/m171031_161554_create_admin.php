<?php

use yii\db\Migration;

class m171031_161554_create_admin extends Migration
{
    public function up()
    {
         $this->insert('user',[
            'email' => 'sk@webbee.pro',
            'auth_key' => 'qp8CtS6UyG9IybBEQWvpWYOdJ6A05zVi',
            'password_hash' => '$2y$13$AAgGUIPB5OcTfgl1NtUz.u0HRUDyhwP4sDH/AMD47cPxrgKXzpExa',
            'auth_key' => 'qp8CtS6UyG9IybBEQWvpWYOdJ6A05zVi',
            'status' => '10',
            'created_at' => time(),
            'updated_at' => time(),
            'first_name' => 'super',
            'last_name' => 'admin'
         ]);

    }

    public function down()
    {
        $this->delete('user', ['id' => 1]);
    }
}
