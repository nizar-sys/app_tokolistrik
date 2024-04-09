<?php

namespace App\Controllers;

use App\Models\RakModel;
use App\Models\MerkModel;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Models\DataBarangModel;
use App\Models\BarangMasukModel;
use App\Controllers\BaseController;

class DataBarangController extends BaseController
{
    protected $dataBarangModel;
    protected $barangMasukModel;
    protected $merkModel;
    protected $kategoriModel;
    protected $authModel;
    protected $rakModel;

    public function __construct()
    {
        $this->dataBarangModel = new DataBarangModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->kategoriModel = new KategoriModel();
        $this->merkModel = new MerkModel();
        $this->authModel = new UserModel();
        $this->rakModel = new RakModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Barang',
            'results' => $this->dataBarangModel->getBarang(),
            'account' => $this->authModel->getUser(session()->get('id')),
            'no' => 1,
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];

        return view('databarang/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Data Barang',
            'page' => 'Tambah Data Barang',
            'account' => $this->authModel->getUser(session()->get('id')),
            'merk' => $this->merkModel->getMerk(),
            'kategori' => $this->kategoriModel->getKategori(),
            'rak' => $this->rakModel->getRak(),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];

        return view('databarang/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_barang' => 'required|min_length[5]',
            'deskripsi' => 'required|min_length[1]',
            'merk_id' => 'required',
            'kategori_id' => 'required',
            'rak_id' => 'required',
            'harga_jual' => 'required|min_length[1]',
            'stok_alert' => 'required|min_length[1]',
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang anda pilih bukan gambar'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('assets/img', $namaSampul);
        }
        $this->dataBarangModel->save([
            'nama_barang' => $this->request->getVar('nama_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'merk_id' => $this->request->getVar('merk_id'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'rak_id' => $this->request->getVar('rak_id'),
            'harga_jual' => $this->request->getVar('harga_jual'),
            'stok_alert' => $this->request->getVar('stok_alert'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('success', 'Data Berhasil Ditambahkan.');
        return redirect()->to('databarang');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Data Barang',
            'page' => 'Edit Data Barang',
            'account' => $this->authModel->getUser(session()->get('id')),
            'merk' => $this->merkModel->getMerk(),
            'kategori' => $this->kategoriModel->getKategori(),
            'rak' => $this->rakModel->getRak(),
            'row' => $this->dataBarangModel->getBarang($id),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];

        return view('databarang/edit', $data);
    }

    public function update($id)
    {
        $rulesSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($rulesSampul->getError() == 4) {
            $rules = 'is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]';
        } else {
            $rules = 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]';
        }

        $rules = [
            'nama_barang' => 'required|min_length[5]',
            'deskripsi' => 'required|min_length[1]',
            'merk_id' => 'required',
            'kategori_id' => 'required',
            'rak_id' => 'required',
            'harga_jual' => 'required|min_length[1]',
            'stok_alert' => 'required|min_length[1]',
            'sampul' => [
                'rules' => $rules,
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Yang anda pilih bukan gambar'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulOld');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('assets/img', $namaSampul);
            // hapus file lama
            if ($this->request->getVar('sampulOld') != 'default.png') {
                // hapus gambar
                unlink('assets/img/' . $this->request->getVar('sampulOld'));
            }
        }

        $this->dataBarangModel->save([
            'barang_id' => $id,
            'nama_barang' => $this->request->getVar('nama_barang'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'merk_id' => $this->request->getVar('merk_id'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'rak_id' => $this->request->getVar('rak_id'),
            'harga_jual' => $this->request->getVar('harga_jual'),
            'stok_alert' => $this->request->getVar('stok_alert'),
            'sampul' => $namaSampul,
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diubahkan.');
        return redirect()->to('databarang');
    }

    public function delete($id)
    {
        $barang = $this->dataBarangModel->find($id);
        if ($barang['sampul'] != 'default.png') {
            // hapus gambar
            unlink('assets/img/' . $barang['sampul']);
        }

        $this->dataBarangModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('databarang');
    }
}
