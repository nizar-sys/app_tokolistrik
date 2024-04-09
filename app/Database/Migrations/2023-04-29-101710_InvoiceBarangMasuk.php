<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InvoiceBarangMasuk extends Migration
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
            'supplier_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
        ]);
        $this->forge->addKey('inv_id', true);
        $this->forge->createTable('tb_invoicebarangmasuk');
    }

    public function down()
    {
        $this->forge->dropTable('tb_invoicebarangmasuk');
    }
}
