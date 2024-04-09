<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'brg_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'barang_id' => [
                'type' => 'INT',
                'constraint' => '3',
            ],
            'harga_jual' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'harga_beli' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'subtotal' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            // 'expired' => [
            //     'type'       => 'DATE',
            //     'null' => true
            // ],
            'supplier_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
        ]);
        $this->forge->addKey('brg_id', true);
        $this->forge->createTable('tb_barangmasuk');
    }

    public function down()
    {
        $this->forge->dropTable('tb_barangmasuk');
    }
}
