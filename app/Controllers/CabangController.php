<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\CabangModel;
use App\Models\DataBarangModel;
use App\Models\UserModel;

class CabangController extends BaseController
{
    protected $userModel;
    protected $barangModel;
    protected $barangMasukModel;
    protected $cabangModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->barangModel = new DataBarangModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->cabangModel = new CabangModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Data Cabang',
            'account' => $this->userModel->getUser(session()->get('id')),
            'results' => $this->cabangModel->getCabang(),
            'no' => 1,
        ];

        return view('data_cabang/index', $data);
    }

    public function create()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Data Cabang',
            'page' => 'Tambah Data Cabang',
            'account' => $this->userModel->getUser(session()->get('id')),
        ];

        $users = $this->userModel->getOwnersAndAdmins();

        $owners = array_filter($users, function ($cabang) {
            return $cabang->role === 'owner';
        });

        $admins = array_filter($users, function ($cabang) {
            return $cabang->role === 'admin';
        });

        $data['owners'] = $owners;
        $data['admins'] = $admins;

        return view('data_cabang/create', $data);
    }

    public function store()
    {

        $rules = [
            'cabang' => 'required|min_length[5]',
            'alamat' => 'required|min_length[5]',
            'owner_id' => 'required',
            'admin_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }
        
        $this->cabangModel->save([
            'cabang' => $this->request->getVar('cabang'),
            'alamat' => $this->request->getVar('alamat'),
            'owner_id' => $this->request->getVar('owner_id'),
            'admin_id' => $this->request->getVar('admin_id'),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('data-cabang');
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Data Cabang',
            'page' => 'Edit Data Cabang',
            'account' => $this->userModel->getUser(session()->get('id')),
            'res' => $this->cabangModel->getCabang($id),
        ];

        $users = $this->userModel->getOwnersAndAdmins();

        $owners = array_filter($users, function ($cabang) {
            return $cabang->role === 'owner';
        });

        $admins = array_filter($users, function ($cabang) {
            return $cabang->role === 'admin';
        });

        $data['owners'] = $owners;
        $data['admins'] = $admins;

        return view('data_cabang/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'cabang' => 'required|min_length[5]',
            'alamat' => 'required|min_length[5]',
            'owner_id' => 'required',
            'admin_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }
        
        $this->cabangModel->save([
            'id' => $id,
            'cabang' => $this->request->getVar('cabang'),
            'alamat' => $this->request->getVar('alamat'),
            'owner_id' => $this->request->getVar('owner_id'),
            'admin_id' => $this->request->getVar('admin_id'),
        ]);
        
        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('data-cabang');
    }

    public function delete($id)
    {
        $this->cabangModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('data-cabang');
    }
}
