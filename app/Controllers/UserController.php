<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\DataBarangModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $barangModel;
    protected $barangMasukModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->barangModel = new DataBarangModel();
        $this->barangMasukModel = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Data User',
            'account' => $this->userModel->getUser(session()->get('id')),
            'results' => array_reverse($this->userModel->getUser()),
            'no' => 1,
        ];

        return view('data_user/index', $data);
    }

    public function create()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Data User',
            'page' => 'Tambah Data User',
            'account' => $this->userModel->getUser(session()->get('id')),
        ];

        return view('data_user/create', $data);
    }

    public function store()
    {

        $rules = [
            'nama_lengkap' => 'required|min_length[5]',
            'alamat' => 'required|min_length[5]|',
            'tanggal_lahir' => 'required|min_length[5]',
            'username' => 'required|min_length[5]',
            'role' => 'required',
            'email' => 'required|min_length[5]',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->userModel->save([
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'alamat' => $this->request->getVar('alamat'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'avatar' => 'user-default.png',
            'role' => $this->request->getVar('role'),
            'is_active' => 1
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('data-user');
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Data User',
            'page' => 'Edit Data User',
            'account' => $this->userModel->getUser(session()->get('id')),
            'res' => $this->userModel->getUser($id),
        ];

        return view('data_user/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[5]',
            'alamat' => 'required|min_length[5]|',
            'tanggal_lahir' => 'required|min_length[5]',
            'username' => 'required|min_length[5]',
            'role' => 'required',
            'email' => 'required|min_length[5]',
            'is_active' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->userModel->save([
            'user_id' => $id,
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'alamat' => $this->request->getVar('alamat'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'username' => $this->request->getVar('username'),
            'role' => $this->request->getVar('role'),
            'email' => $this->request->getVar('email'),
            'is_active' => $this->request->getVar('is_active')
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('data-user');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('data-user');
    }
}
