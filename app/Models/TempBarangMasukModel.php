<?php

namespace App\Models;

use CodeIgniter\Model;

class TempBarangMasukModel extends Model
{
    protected $table            = 'tempbarangmasuks';
    protected $primaryKey       = 'brg_id';
    protected $allowedFields    = ['brg_id', 'invoice', 'barang_id', 'harga_jual', 'harga_beli', 'jumlah', 'subtotal', 'stok', 'expired', 'supplier_id', 'tanggal'];

    public function showDataTemp($invoice)
    {
        return $this->join('tb_suppliers', 'tempbarangmasuks.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tempbarangmasuks.barang_id = tb_barang.barang_id')->where('tempbarangmasuks.invoice', $invoice)->findAll();
    }
}
