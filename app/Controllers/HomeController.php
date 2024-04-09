<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Models\DataBarangModel;
use App\Models\BarangMasukModel;
use App\Models\BarangKeluarModel;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
    protected $authModel;
    protected $barangModel;
    protected $supplierModel;
    protected $barangMasukModel;
    protected $barangKeluarModel;

    public function __construct()
    {
        $this->authModel = new UserModel();
        $this->barangModel = new DataBarangModel();
        $this->supplierModel = new SupplierModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->barangKeluarModel = new BarangKeluarModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Cipta Sarana',
            'account' => $this->authModel->getUser(session()->get('id')),
            'countBarang' => $this->barangModel->countBarang(),
            'countSupplier' => $this->supplierModel->countAllResults(),
            'countBarangMasuk' => $this->barangMasukModel->countBarangMasuk(),
            'countBarangKeluar' => $this->barangKeluarModel->countBarangKeluar(),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];

        return view('index', $data);
    }
}
