<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'rak_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_rak' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kapasitas' => [
                'type'       => 'int',
                'constraint' => '11',
            ],
            'lokasi' => [
                'type'       => 'TEXT',
            ],
            'cabang_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('rak_id', true);
        $this->forge->addForeignKey('cabang_id', 'tb_cabang', 'id');
        $this->forge->createTable('tb_rak');
    }

    public function down()
    {
        $this->forge->dropTable('tb_rak');
    }
}
