<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\DataBarangModel;
use App\Models\MerkModel;
use App\Models\UserModel;

class MerkController extends BaseController
{
    protected $merkModel;
    protected $authModel;
    protected $dataBarangModel;
    protected $barangMasukModel;

    public function __construct()
    {
        $this->merkModel = new MerkModel();
        $this->authModel = new UserModel();
        $this->dataBarangModel = new DataBarangModel();
        $this->barangMasukModel = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Merk',
            'account' => $this->authModel->getUser(session()->get('id')),
            'results' => $this->merkModel->getMerk(),
            'no' => 1,
        ];

        return view('merk/index', $data);
    }

    public function create()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Merk',
            'account' => $this->authModel->getUser(session()->get('id')),
            'page' => 'Tambah Data Generic',
        ];

        return view('merk/create', $data);
    }

    public function store()
    {
        $rules = [
            'merk' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->merkModel->save([
            'merk' => $this->request->getVar('merk'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('merk');
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Merk',
            'page' => 'Edit Data Generic',
            'account' => $this->authModel->getUser(session()->get('id')),
            'res' => $this->merkModel->getMerk($id),
        ];

        return view('merk/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'merk' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->merkModel->save([
            'merk_id' => $id,
            'merk' => $this->request->getVar('merk'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('merk');
    }

    public function delete($id)
    {
        $this->merkModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('merk');
    }
}
