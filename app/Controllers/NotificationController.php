<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Models\BarangMasukModel;
use App\Controllers\BaseController;
use App\Models\DataBarangModel;
use App\Models\TempBarangMasukModel;
use App\Models\InvoiceBarangMasukModel;

class NotificationController extends BaseController
{
    protected $authModel;
    protected $supplierModel;
    protected $barangMasukModel;
    protected $dataBarangModel;
    protected $tempBarangMasuk;
    protected $invoiceBarangMasuk;

    public function __construct()
    {
        $this->authModel = new UserModel();
        $this->supplierModel = new SupplierModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->dataBarangModel = new DataBarangModel();
        $this->tempBarangMasuk = new TempBarangMasukModel();
        $this->invoiceBarangMasuk = new InvoiceBarangMasukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Notification',
            'account' => $this->authModel->getUser(session()->get('id')),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];

        return view('notification/index', $data);
    }


    public function menipis()
    {
        $data = [
            'title' => 'Barang Menipis',
            'account' => $this->authModel->getUser(session()->get('id')),
            'invoice' => $this->invoiceBarangMasuk->asObject()->findAll(),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];


        return view('notification/barangmenipis', $data);
    }

    public function habis()
    {
        $data = [
            'title' => 'Barang Habis',
            'account' => $this->authModel->getUser(session()->get('id')),
            'invoice' => $this->invoiceBarangMasuk->asObject()->findAll(),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];


        return view('notification/baranghabis', $data);
    }
}
