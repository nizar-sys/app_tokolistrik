<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Models\BarangMasukModel;
use App\Controllers\BaseController;
use App\Models\DataBarangModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;
    protected $authModel;
    protected $barangMasukModel;
    protected $dataBarangModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->authModel = new UserModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->dataBarangModel = new DataBarangModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Kategori',
            'account' => $this->authModel->getUser(session()->get('id')),
            'results' => $this->kategoriModel->getKategori(),
            'no' => 1,
        ];

        return view('kategori/index', $data);
    }

    public function create()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Kategori',
            'account' => $this->authModel->getUser(session()->get('id')),
            'page' => 'Tambah Data Kategori',
        ];

        return view('kategori/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_kategori' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('kategori');
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Kategori',
            'page' => 'Edit Data Kategori',
            'account' => $this->authModel->getUser(session()->get('id')),
            'res' => $this->kategoriModel->getKategori($id),
        ];

        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_kategori' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->kategoriModel->save([
            'kategori_id' => $id,
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('kategori');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('kategori');
    }
}
