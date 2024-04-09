<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StockOpname extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'so_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_so' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'brg_id' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'barang_id' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'stock_fisik' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'selisih' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('so_id', true);
        $this->forge->createTable('tb_stockopname');
    }

    public function down()
    {
        $this->forge->dropTable('tb_stockopname');
    }
}
