<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RakModel;
use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\CabangModel;
use App\Models\DataBarangModel;

class RakController extends BaseController
{
    protected $rakModel;
    protected $barangMasukModel;
    protected $dataBarangModel;
    protected $authModel;
    protected $cabangModel;

    public function __construct()
    {
        $this->rakModel = new RakModel();
        $this->authModel = new UserModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->dataBarangModel = new DataBarangModel();
        $this->cabangModel = new CabangModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Rak',
            'account' => $this->authModel->getUser(session()->get('id')),
            'results' => $this->rakModel->getRak(),
            'no' => 1,
        ];

        return view('rak/index', $data);
    }

    public function create()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Rak',
            'account' => $this->authModel->getUser(session()->get('id')),
            'page' => 'Tambah Data Rak',
            'cabang' => $this->cabangModel->getCabang(),
        ];

        return view('rak/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_rak' => 'required|min_length[5]|is_unique[tb_rak.nama_rak]',
            'kapasitas' => 'required|min_length[1]',
            'lokasi' => 'required|min_length[1]',
            'cabang_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->rakModel->save([
            'nama_rak' => $this->request->getVar('nama_rak'),
            'kapasitas' => $this->request->getVar('kapasitas'),
            'lokasi' => $this->request->getVar('lokasi'),
            'cabang_id' => $this->request->getVar('cabang_id'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('rak');
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Rak',
            'page' => 'Edit Data Rak',
            'account' => $this->authModel->getUser(session()->get('id')),
            'res' => $this->rakModel->getRak($id),
            'cabang' => $this->cabangModel->getCabang(),
        ];

        return view('rak/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_rak' => 'required|min_length[5]',
            'kapasitas' => 'required|min_length[1]',
            'lokasi' => 'required|min_length[1]',
            'cabang_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->rakModel->save([
            'rak_id' => $id,
            'nama_rak' => $this->request->getVar('nama_rak'),
            'kapasitas' => $this->request->getVar('kapasitas'),
            'lokasi' => $this->request->getVar('lokasi'),
            'cabang_id' => $this->request->getVar('cabang_id'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('rak');
    }

    public function delete($id)
    {
        $this->rakModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('rak');
    }
}
