<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\DataBarangModel;

class SupplierController extends BaseController
{
    protected $supplierModel;
    protected $authModel;
    protected $dataBarangModel;
    protected $barangMasukModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->authModel = new UserModel();
        $this->dataBarangModel = new DataBarangModel();
        $this->barangMasukModel = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Supplier',
            'account' => $this->authModel->getUser(session()->get('id')),
            'results' => $this->supplierModel->getSupplier(),
            'no' => 1,
        ];

        return view('supplier/index', $data);
    }

    public function create()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Supplier',
            'page' => 'Tambah Data Supplier',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        return view('supplier/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[5]|regex_match[/^[a-zA-Z ]+$/]',
            'no_telpon' => 'required|numeric|min_length[5]|max_length[15]',
            'alamat' => 'required|min_length[5]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->supplierModel->save([
            'nama_supplier' => $this->request->getVar('nama_lengkap'),
            'no_telpon' => $this->request->getVar('no_telpon'),
            'alamat' => $this->request->getVar('alamat'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('supplier');
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Supplier',
            'page' => 'Edit Data Supplier',
            'account' => $this->authModel->getUser(session()->get('id')),
            'res' => $this->supplierModel->getSupplier($id),
        ];

        return view('supplier/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[5]|regex_match[/^[a-zA-Z ]+$/]',
            'no_telpon' => 'required|numeric|min_length[5]|max_length[15]',
            'alamat' => 'required|min_length[5]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->supplierModel->save([
            'supplier_id' => $id,
            'nama_supplier' => $this->request->getVar('nama_lengkap'),
            'no_telpon' => $this->request->getVar('no_telpon'),
            'alamat' => $this->request->getVar('alamat'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('supplier');
    }

    public function delete($id)
    {
        $this->supplierModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('supplier');
    }
}
