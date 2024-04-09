<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BarangMasukModel;
use App\Models\BarangKeluarModel;
use App\Controllers\BaseController;
use App\Models\DataBarangModel;
use App\Models\TempBarangKeluarModel;
use App\Models\InvoiceBarangKeluarModel;

class BarangKeluarController extends BaseController
{
    protected $authModel;
    protected $supplierModel;
    protected $barangKeluarModel;
    protected $barangMasukModel;
    protected $barangModel;
    protected $tempBarangKeluar;
    protected $invoiceBarangKeluar;
    public function __construct()
    {
        $this->authModel = new UserModel();
        $this->barangKeluarModel = new BarangKeluarModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->barangModel = new DataBarangModel();
        $this->tempBarangKeluar = new TempBarangKeluarModel();
        $this->invoiceBarangKeluar = new InvoiceBarangKeluarModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Barang Keluar',
            'account' => $this->authModel->getUser(session()->get('id')),
            'invoice' => $this->invoiceBarangKeluar->getInvoice(),
        ];

        return view('barang_keluar/index', $data);
    }

    public function create()
    {
        // Get Kode Barang
        $getKodeInvoice = $this->invoiceBarangKeluar->selectMaxWhereBranch();
        $getKode = $getKodeInvoice['invoice'];
        $urutan = (int) substr($getKode, 4, 4);
        $urutan++;
        $huruf = 'K';
        $newKodeInvoice = $huruf . sprintf("%04s", $urutan);

        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Barang Keluar',
            'account' => $this->authModel->getUser(session()->get('id')),
            'invoice' => $newKodeInvoice,
            'barang' => $this->barangMasukModel->getBarang(),
        ];

        // dd($this->barangKeluarModel->showDataTemp('BK0001'));

        return view('barang_keluar/create', $data);
    }

    public function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $getBarang = $this->barangKeluarModel->showDataTemp($invoice);
            if ($getBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'dataTemp' => $getBarang
                ];

                $json = [
                    'success' => view('barang_keluar/datatemp', $data),
                    'data' => $getBarang
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function getDataBarang()
    {
        if ($this->request->isAJAX()) {
            $brgm_id = $this->request->getVar('brgm_id');
            $dataBarang = $this->barangMasukModel->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.brg_id', $brgm_id)->first();

            if ($dataBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'barang_id' => $dataBarang['barang_id'],
                    'nama_barang' => $dataBarang['nama_barang'],
                    'harga_jual' => $dataBarang['harga_jual'],
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

    public function storeBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $brg_id = $this->request->getVar('brg_id');
            $barang_id = $this->request->getVar('barang_id');
            $harga_jual = $this->request->getVar('harga_jual');
            $jumlah = $this->request->getVar('jumlah');
            $subtotal = intval($jumlah) * intval($harga_jual);
            $tanggal = $this->request->getVar('tanggal');

            $this->barangKeluarModel->save([
                'invoice' => $invoice,
                'brgm_id' => $brg_id,
                'barang_id' => $barang_id,
                'harga_jual' => $harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'tanggal' => $tanggal,
                'user_id' => session()->get('id')
            ]);

            $json = [
                'success' => 'Data Berhasil Ditambahkan',
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $this->barangKeluarModel->delete($id);

            $json = [
                'success' => 'Item Berhasil Dihapuskan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function selesaiTransaksi()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $tanggal = $this->request->getVar('tanggal');

            $dataTemp = $this->barangKeluarModel->where('invoice', $invoice)->findAll();

            if ($dataTemp == null) {
                $json = [
                    'error' => 'Maaf, data untuk invoice ini belum ada'
                ];
            } else {
                $this->invoiceBarangKeluar->save([
                    'invoice' => $invoice,
                    'tgl_invoice' => $tanggal,
                ]);

                $json = [
                    'success' => 'Transaksi Berhasil Disimpan'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function edit($invoice)
    {
        $cekInvoice = $this->barangKeluarModel->cekInvoice($invoice)->first();

        if ($cekInvoice != null) {
            $row = $cekInvoice;

            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'title' => 'Barang Keluar',
                'invoice' => $row['invoice'],
                'tanggal' => $row['tgl_invoice'],
                'account' => $this->authModel->getUser(session()->get('id')),
                'barang' => $this->barangMasukModel->getBarang(),
            ];

            // dd($this->barangKeluarModel->dataBarangByID(7));

            return view('barang_keluar/edit', $data);
        } else {
            $row = $this->invoiceBarangKeluar->where('invoice', $invoice)->first();

            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'title' => 'Barang Keluar',
                'invoice' => $row['invoice'],
                'tanggal' => $row['tgl_invoice'],
                'account' => $this->authModel->getUser(session()->get('id')),
                'barang' => $this->barangMasukModel->getBarang(),
            ];

            // dd($this->barangKeluarModel->dataBarangByID(7));

            return view('barang_keluar/edit', $data);
        }
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $getBarang = $this->barangKeluarModel->showDataDetail($invoice);
            if ($getBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'dataDetail' => $getBarang,
                ];

                $json = [
                    'success' => view('barang_keluar/datadetail', $data),
                    'data' => $data,
                    'totalHarga' => "Rp " . number_format($this->barangKeluarModel->ambiltotalharga($invoice), 0, ',', '.'),
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function editItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $ambilBarang = $this->barangKeluarModel->dataBarangByID($id);
            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'barang_id' => $ambilBarang['barang_id'],
                'nama_barang' => $ambilBarang['nama_barang'],
                'harga_jual' => $ambilBarang['harga_jual'],
                'stok' => $ambilBarang['stok'],
                'jumlah' => $ambilBarang['jumlah'],
                'user_id' => session()->get('id')
            ];

            $json = [
                'success' => $data
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function editDetailItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $harga_jual = $this->request->getVar('harga_jual');
            $jumlah = $this->request->getVar('jumlah');
            $subtotal = intval($jumlah) * intval($harga_jual);

            $this->barangKeluarModel->save([
                'id' => $id,
                'harga_jual' => $harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'user_id' => session()->get('id')
            ]);

            $json = [
                'success' => 'Item Berhasil Diperbaharui'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function deleteDetail()
    {
        if ($this->request->isAJAX()) {
            $brg_id = $this->request->getVar('brg_id');

            $this->barangKeluarModel->delete($brg_id);

            $json = [
                'success' => 'Item Berhasil Dihapuskan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function storeBarangKeluar2()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $barang_id = $this->request->getVar('barang_id');
            $nama_barang = $this->request->getVar('nama_barang');
            $harga_jual = $this->request->getVar('harga_jual');
            $jumlah = $this->request->getVar('jumlah');
            $subtotal = intval($jumlah) * intval($harga_jual);

            $this->barangKeluarModel->save([
                'invoice' => $invoice,
                'barang_id' => $barang_id,
                'nama_barang' => $nama_barang,
                'harga_jual' => $harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'user_id' => session()->get('id')
            ]);

            $json = [
                'success' => 'Data Berhasil Ditambahkan',
                'subtotal' => $subtotal
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
