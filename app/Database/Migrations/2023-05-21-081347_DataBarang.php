<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'barang_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_barang' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'merk_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'kategori_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'harga_jual' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'rak_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'stok_alert' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'sampul' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => 'default.png'
            ],
        ]);
        $this->forge->addKey('barang_id', true);
        $this->forge->createTable('tb_barang');
    }

    public function down()
    {
        $this->forge->dropTable('tb_barang');
    }
}
