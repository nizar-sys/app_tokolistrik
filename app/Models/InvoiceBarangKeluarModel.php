<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceBarangKeluarModel extends Model
{
    protected $table            = 'tb_invoicebarangkeluar';
    protected $primaryKey       = 'inv_id';
    protected $allowedFields    = ['inv_id', 'invoice', 'tgl_invoice'];

    public function getInvoice($id = null)
    {
        $this
            ->join('tb_barangkeluar', 'tb_invoicebarangkeluar.invoice = tb_barangkeluar.invoice')
            ->join('tb_barang', 'tb_barangkeluar.barang_id = tb_barang.barang_id')
            ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
            ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
            ->orderBy('tb_invoicebarangkeluar.inv_id', 'DESC')
            ->asObject();

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        if ($id === null) {
            return $this->findAll();
        }

        return $this->where('tb_invoicebarangkeluar.inv_id', $id)->first();
    }

    public function selectMaxWhereBranch()
    {
        $this->selectMax('tb_invoicebarangkeluar.invoice', 'invoice');
        $this->join('tb_barangkeluar', 'tb_invoicebarangkeluar.invoice = tb_barangkeluar.invoice');
        $this->join('tb_barang', 'tb_barangkeluar.barang_id = tb_barang.barang_id');
        $this->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id');
        $this->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id');

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->asArray()->first();
    }
}
