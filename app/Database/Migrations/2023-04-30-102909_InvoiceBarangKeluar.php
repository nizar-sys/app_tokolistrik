<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InvoiceBarangKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'inv_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'invoice' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'tgl_invoice' => [
                'type'       => 'DATE',
                'null' => true
            ],
        ]);
        $this->forge->addKey('inv_id', true);
        $this->forge->createTable('tb_invoicebarangkeluar');
    }

    public function down()
    {
        $this->forge->dropTable('tb_invoicebarangkeluar');
    }
}
