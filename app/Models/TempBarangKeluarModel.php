<?php

namespace App\Models;

use CodeIgniter\Model;

class TempBarangKeluarModel extends Model
{
    protected $table            = 'tempbarangkeluars';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'invoice', 'brgm_id', 'barang_id', 'harga_jual', 'jumlah', 'subtotal', 'tanggal', 'user_id'];

    public function showDataTemp($invoice)
    {
        return $this->join('tb_barang', 'tempbarangkeluars.barang_id = tb_barang.barang_id')->where('tempbarangkeluars.invoice', $invoice)->findAll();
    }
}
