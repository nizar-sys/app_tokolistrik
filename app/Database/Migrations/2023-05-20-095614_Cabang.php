<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cabang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'cabang' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'owner_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'admin_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('owner_id', 'tb_users', 'user_id');
        $this->forge->addForeignKey('admin_id', 'tb_users', 'user_id');

        $this->forge->createTable('tb_cabang');
    }

    public function down()
    {
        $this->forge->dropTable('tb_cabang');
    }
}
