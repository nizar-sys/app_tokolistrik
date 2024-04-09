<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table            = 'tb_barangkeluar';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'invoice', 'brgm_id', 'barang_id', 'harga_jual', 'jumlah', 'subtotal', 'tanggal', 'user_id'];

    public function getDataBarangKeluar()
    {
        return $this->asObject()->findAll();
    }

    public function cekInvoice($invoice)
    {
        return $this->join('tb_invoicebarangkeluar', 'tb_barangkeluar.invoice = tb_invoicebarangkeluar.invoice')->where('tb_barangkeluar.invoice', $invoice);
    }

    public function showDataDetail($invoice)
    {
        return $this->join('tb_users', 'tb_barangkeluar.user_id = tb_users.user_id')->join('tb_barang', 'tb_barangkeluar.barang_id = tb_barang.barang_id')->where('tb_barangkeluar.invoice', $invoice)->findAll();
    }

    public function ambilTotalHarga($invoice)
    {
        $query = $this->where('invoice', $invoice)->findAll();

        $totalHarga = 0;
        foreach ($query as $row) {
            $totalHarga += $row['subtotal'];
        }

        return $totalHarga;
    }

    public function dataBarangByID($id)
    {
        return $this->select('tb_barang.nama_barang, tb_barang.harga_jual, tb_barangmasuk.stok, tb_barangkeluar.jumlah, tb_barangkeluar.barang_id')->join('tb_barang', 'tb_barang.barang_id = tb_barangkeluar.barang_id')->join('tb_barangmasuk', 'tb_barangkeluar.brgm_id = tb_barangmasuk.brg_id')->where('tb_barangkeluar.id', $id)->first();
    }

    public function showDataTemp($invoice)
    {
        return $this->join('tb_users', 'tb_barangkeluar.user_id = tb_users.user_id')->join('tb_barang', 'tb_barangkeluar.barang_id = tb_barang.barang_id')->where('tb_barangkeluar.invoice', $invoice)->findAll();
    }

    public function showDataBarang($tgl_awal, $tgl_akhir)
    {
        $this->select('tb_barangkeluar.invoice, tb_barang.nama_barang, tb_barang.harga_jual, tb_barangmasuk.harga_beli, tb_barangkeluar.jumlah, tb_barangkeluar.subtotal')
        ->join('tb_barang', 'tb_barangkeluar.barang_id = tb_barang.barang_id')
        ->join('tb_barangmasuk', 'tb_barangkeluar.brgm_id = tb_barangmasuk.brg_id')
        ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
        ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
        ->where("tb_barangkeluar.tanggal BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}'");

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->findAll();
    }

    public function countBarangKeluar()
    {
        $this
            ->join('tb_barang', 'tb_barangkeluar.barang_id = tb_barang.barang_id')
            ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
            ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
            ->orderBy('tb_barang.barang_id', 'DESC')
            ->asObject();

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->countAllResults();
    }
}
