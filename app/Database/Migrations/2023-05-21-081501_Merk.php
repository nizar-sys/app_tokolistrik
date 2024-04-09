<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Merk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'merk_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'merk' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('merk_id', true);
        $this->forge->createTable('tb_merk');
    }

    public function down()
    {
        $this->forge->dropTable('tb_merk');
    }
}
