<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'tb_barangmasuk';
    protected $primaryKey       = 'brg_id';
    protected $allowedFields    = ['brg_id', 'invoice', 'barang_id', 'harga_jual', 'harga_beli', 'jumlah', 'subtotal', 'stok', 'supplier_id', 'tanggal', 'user_id'];

    public function cekInvoice($invoice)
    {
        return $this->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_invoicebarangmasuk', 'tb_barangmasuk.invoice = tb_invoicebarangmasuk.invoice')->where('tb_barangmasuk.invoice', $invoice);
    }

    public function showDataDetail($invoice)
    {
        return $this->join('tb_users', 'tb_barangmasuk.user_id = tb_users.user_id')->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.invoice', $invoice)->orderBy('tb_barangmasuk.brg_id', 'ASC')->findAll();
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
        return $this->join('tb_barang', 'tb_barang.barang_id = tb_barangmasuk.barang_id')->where('tb_barangmasuk.brg_id', $id)->first();
    }

    public function getBarang()
    {
        $this->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')
        ->orderBy('tb_barangmasuk.invoice', 'ASC')->where('tb_barangmasuk.stok != 0');

        if (session()->get('role') == 'admin') {
            $this->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->asObject()->findAll();
    }

    public function showDataBarang($tgl_awal, $tgl_akhir)
    {
        $this
        ->join('tb_users', 'tb_barangmasuk.user_id = tb_users.user_id')
        ->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')
        ->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')
        ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
        ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
        ->where("tb_barangmasuk.tanggal BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}'");

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->findAll();
    }

    public function getDataBarangExpired()
    {
        return $this->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->asObject()->findAll();
    }

    public function countBarangMasuk()
    {
        $this
            ->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')
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
