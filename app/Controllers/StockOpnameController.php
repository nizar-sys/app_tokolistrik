<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\DataBarangModel;
use App\Models\StockOpnameModel;
use App\Models\UserModel;

class StockOpnameController extends BaseController
{
    protected $authModel;
    protected $barangModel;
    protected $barangMasukModel;
    protected $stockOpnameModel;

    public function __construct()
    {
        $this->authModel = new UserModel();
        $this->barangModel = new DataBarangModel();
        $this->stockOpnameModel = new StockOpnameModel();
        $this->barangMasukModel = new BarangMasukModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'StockOpname',
            'account' => $this->authModel->getUser(session()->get('id')),
            'result' => $this->stockOpnameModel->getStockOpname(),
        ];

        // dd($data['result']);

        return view('stockopname/index', $data);
    }

    public function create()
    {
        // Get Kode Barang
        $getKodeSO = $this->stockOpnameModel->selectMaxWhereBranch();
        $getKode = $getKodeSO['kode_so'];
        $urutan = (int) substr($getKode, 4, 4);
        $urutan++;
        $huruf = 'SO';
        $newKodeSO = $huruf . sprintf("%04s", $urutan);

        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'StockOpname',
            'account' => $this->authModel->getUser(session()->get('id')),
            'dataBarang' => $this->barangMasukModel->getBarang(),
            'kodeSO' => $newKodeSO,
        ];

        // dd($data['dataObat']);

        return view('stockopname/create', $data);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $kode_so = $this->request->getVar('kode_so');
            $brg_id = $this->request->getVar('brg_id');
            $barang_id = $this->request->getVar('barang_id');
            $stock_fisik = $this->request->getVar('stock_fisik');
            $selisih = $this->request->getVar('selisih');
            $keterangan = $this->request->getVar('keterangan');
            $tanggal = $this->request->getVar('tanggal');
            $user_id = session()->get('id');

            $this->stockOpnameModel->save([
                'kode_so' => $kode_so,
                'brg_id' => $brg_id,
                'barang_id' => $barang_id,
                'stock_fisik' => $stock_fisik,
                'selisih' => $selisih,
                'keterangan' => $keterangan,
                'tanggal' => $tanggal,
                'user_id' => $user_id,
            ]);

            $json = [
                'success' => 'Data Berhasil Ditambahkan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function edit($id)
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'StockOpname',
            'account' => $this->authModel->getUser(session()->get('id')),
            'dataBarang' => $this->barangMasukModel->getBarang(),
            'res' => $this->stockOpnameModel->getStockOpname($id),
        ];

        return view('stockopname/edit', $data);
    }

    public function update()
    {

        if ($this->request->isAJAX()) {
            $so_id = $this->request->getVar('so_id');
            $stock_fisik = $this->request->getVar('stock_fisik');
            $selisih = $this->request->getVar('selisih');
            $keterangan = $this->request->getVar('keterangan');
            $user_id = session()->get('id');

            $this->stockOpnameModel->save([
                'so_id' => $so_id,
                'stock_fisik' => $stock_fisik,
                'selisih' => $selisih,
                'keterangan' => $keterangan,
                'user_id' => $user_id,
            ]);

            $json = [
                'success' => 'Data Berhasil Diubahkan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function delete($id)
    {
        $this->stockOpnameModel->delete($id);
        session()->setFlashdata('success', 'Data Berhasil Dihapuskan.');
        return redirect()->to('stockopname');
    }

    public function getStockBarang()
    {
        if ($this->request->isAJAX()) {
            $brg_id = $this->request->getVar('brg_id');
            $dataBarang = $this->barangMasukModel->where('brg_id', $brg_id)->first();
            if ($dataBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'barang_id' => $dataBarang['barang_id'],
                    'stok' => $dataBarang['stok'],
                ];

                $json = [
                    'success' => $data
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
