<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceBarangMasukModel extends Model
{
    protected $table            = 'tb_invoicebarangmasuk';
    protected $primaryKey       = 'inv_id';
    protected $allowedFields    = ['inv_id', 'invoice', 'tgl_invoice', 'supplier_id'];

    public function cekInvoice($invoice)
    {
        return $this->join('tb_suppliers', 'tb_invoicebarangmasuk.supplier_id = tb_suppliers.supplier_id')->where('invoice', $invoice);
    }

    // get invoice barang masuk
    public function getInvoice($id = null)
    {
        $this
            ->join('tb_suppliers', 'tb_invoicebarangmasuk.supplier_id = tb_suppliers.supplier_id')
            ->join('tb_barangmasuk', 'tb_invoicebarangmasuk.invoice = tb_barangmasuk.invoice')
            ->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')
            ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
            ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
            ->orderBy('tb_invoicebarangmasuk.inv_id', 'DESC')
            ->asObject();

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        if ($id === null) {
            return $this->findAll();
        }

        return $this->where('tb_invoicebarangmasuk.inv_id', $id)->first();
    }

    public function selectMaxWhereBranch()
    {
        $this->selectMax('tb_invoicebarangmasuk.invoice', 'invoice');
        $this->join('tb_suppliers', 'tb_invoicebarangmasuk.supplier_id = tb_suppliers.supplier_id');
        $this->join('tb_barangmasuk', 'tb_invoicebarangmasuk.invoice = tb_barangmasuk.invoice');
        $this->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id');
        $this->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id');
        $this->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id');

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->asArray()->first();
    }
}
