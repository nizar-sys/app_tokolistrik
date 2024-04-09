<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'role' => [
                'type'       => 'enum',
                'constraint' => ['owner', 'admin'],
                'default' => 'admin'
            ],
            'is_active' => [
                'type'       => 'enum',
                'constraint' => ['1', '0'],
                'default' => '1'
            ],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('tb_users');
    }

    public function down()
    {
        $this->forge->dropTable('tb_users');
    }
}
