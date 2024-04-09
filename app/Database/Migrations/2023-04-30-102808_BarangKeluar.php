<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'brgm_id' => [
                'type' => 'INT',
                'constraint' => '3',
            ],
            'barang_id' => [
                'type' => 'INT',
                'constraint' => '3',
            ],
            'harga_jual' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'subtotal' => [
                'type' => 'INT',
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_barangkeluar');

        $this->db->query('CREATE TRIGGER `AfterDelete` AFTER DELETE ON `tb_barangkeluar` FOR EACH ROW UPDATE tb_barangmasuk SET tb_barangmasuk.stok = tb_barangmasuk.stok + old.jumlah WHERE tb_barangmasuk.brg_id = old.brgm_id');
        $this->db->query('CREATE TRIGGER `AfterInsert` AFTER INSERT ON `tb_barangkeluar` FOR EACH ROW UPDATE tb_barangmasuk SET tb_barangmasuk.stok = tb_barangmasuk.stok - NEW.jumlah WHERE tb_barangmasuk.brg_id = NEW.brgm_id');
        $this->db->query('CREATE TRIGGER `AfterUpdateKurang` AFTER UPDATE ON `tb_barangkeluar` FOR EACH ROW UPDATE tb_barangmasuk SET tb_barangmasuk.stok = tb_barangmasuk.stok + old.jumlah WHERE tb_barangmasuk.brg_id = old.brgm_id');
        $this->db->query('CREATE TRIGGER `AfterUpdateTambah` AFTER UPDATE ON `tb_barangkeluar` FOR EACH ROW UPDATE tb_barangmasuk SET tb_barangmasuk.stok = tb_barangmasuk.stok - NEW.jumlah WHERE tb_barangmasuk.brg_id = NEW.brgm_id');
    }

    public function down()
    {
        $this->forge->dropTable('tb_barangkeluar');
    }
}
