<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Models\BarangMasukModel;
use App\Controllers\BaseController;
use App\Models\DataBarangModel;
use App\Models\TempBarangMasukModel;
use App\Models\InvoiceBarangMasukModel;
use App\Models\InvoiceBarangKeluarModel;
use App\Models\RakModel;

class BarangMasukController extends BaseController
{
    protected $authModel;
    protected $supplierModel;
    protected $barangMasukModel;
    protected $barangModel;
    protected $tempBarangMasuk;
    protected $invoiceBarangMasuk;
    protected $invoiceBarangKeluar;
    protected $rakModel;

    public function __construct()
    {
        $this->authModel = new UserModel();
        $this->supplierModel = new SupplierModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->barangModel = new DataBarangModel();
        $this->tempBarangMasuk = new TempBarangMasukModel();
        $this->invoiceBarangMasuk = new InvoiceBarangMasukModel();
        $this->invoiceBarangKeluar = new InvoiceBarangKeluarModel();
        $this->rakModel = new RakModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Barang Masuk',
            'account' => $this->authModel->getUser(session()->get('id')),
            'invoice' => $this->invoiceBarangMasuk->getInvoice(),
        ];

        return view('barang_masuk/index', $data);
    }

    public function create()
    {
        // Get Kode Barang
        $getKodeInvoice = $this->invoiceBarangMasuk->selectMaxWhereBranch();
        $getKode = $getKodeInvoice['invoice'];
        $urutan = (int) substr($getKode, 4, 4);
        $urutan++;
        $huruf = 'M';
        $newKodeInvoice = $huruf . sprintf("%04s", $urutan);

        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Barang Masuk',
            'account' => $this->authModel->getUser(session()->get('id')),
            'supplier' => $this->supplierModel->getSupplier(),
            'barang' => $this->barangModel->getBarang(),
            'invoice' => $newKodeInvoice,
        ];

        return view('barang_masuk/create', $data);
    }

    public function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $getBarang = $this->barangMasukModel->showDataDetail($invoice);
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
                    'success' => view('barang_masuk/datatemp', $data),
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
            $barang_id = $this->request->getVar('barang_id');
            $dataBarang = $this->barangModel->join('tb_merk', 'tb_barang.merk_id = tb_merk.merk_id')->join('tb_kategori', 'tb_barang.kategori_id = tb_kategori.kategori_id')->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')->where('tb_barang.barang_id', $barang_id)->first();
            $sumDataBarang = $this->barangMasukModel->selectSum('stok')->where('barang_id', $barang_id)->first();
            if ($dataBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'harga_jual' => $dataBarang['harga_jual'],
                    'kapasitas' => $dataBarang['kapasitas'],
                    'stokNow' => $sumDataBarang['stok']
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

    public function storeTemp()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $barang_id = $this->request->getVar('barang_id');
            $harga_beli = $this->request->getVar('harga_beli');
            $harga_jual = $this->request->getVar('harga_jual');
            $jumlah = $this->request->getVar('jumlah');
            $subtotal = intval($jumlah) * intval($harga_beli);
            $supplier_id = $this->request->getVar('supplier_id');
            $tanggal = $this->request->getVar('tanggal');

            $this->barangMasukModel->save([
                'invoice' => $invoice,
                'barang_id' => $barang_id,
                'harga_jual' => $harga_jual,
                'harga_beli' => $harga_beli,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'stok' => $jumlah,
                'supplier_id' => $supplier_id,
                'tanggal' => $tanggal,
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

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $this->barangMasukModel->delete($id);

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
            // $supplier_id = $this->request->getVar('supplier_id');

            $dataTemp = $this->barangMasukModel->where('invoice', $invoice)->findAll();
            $supplier_id = $this->barangMasukModel->where('invoice', $invoice)->first();

            if ($dataTemp == null) {
                $json = [
                    'error' => 'Maaf, data untuk invoice ini belum ada'
                ];
            } else {
                $this->invoiceBarangMasuk->save([
                    'invoice' => $invoice,
                    'tgl_invoice' => $tanggal,
                    'supplier_id' => $supplier_id['supplier_id']
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
        $cekInvoice = $this->barangMasukModel->cekInvoice($invoice)->first();

        if ($cekInvoice != null) {
            $row = $cekInvoice;
            $supplier_id = $cekInvoice['supplier_id'];

            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'title' => 'Barang Masuk',
                'invoice' => $row['invoice'],
                'tanggal' => $row['tgl_invoice'],
                'supplier_id' => $row['supplier_id'],
                'supplier_name' => $row['nama_supplier'],
                'account' => $this->authModel->getUser(session()->get('id')),
                'supplier' => $this->supplierModel->getSupplier(),
                'barang' => $this->barangModel->getBarang(),
                'supplier_id' => $supplier_id,
            ];

            return view('barang_masuk/edit', $data);
        } else {
            $cekInvoice = $this->invoiceBarangMasuk->cekInvoice($invoice)->first();
            $row = $cekInvoice;

            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'title' => 'Barang Masuk',
                'invoice' => $row['invoice'],
                'tanggal' => $row['tgl_invoice'],
                'supplier_id' => $row['supplier_id'],
                'supplier_name' => $row['nama_supplier'],
                'account' => $this->authModel->getUser(session()->get('id')),
                'supplier' => $this->supplierModel->getSupplier(),
                'barang' => $this->barangModel->getBarang(),
            ];

            return view('barang_masuk/edit', $data);
        }
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $getBarang = $this->barangMasukModel->showDataDetail($invoice);
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
                    'success' => view('barang_masuk/datadetail', $data),
                    'totalHarga' => "Rp " . number_format($this->barangMasukModel->ambiltotalharga($invoice), 0, ',', '.'),
                    'data' => $data
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
            $brg_id = $this->request->getVar('brg_id');

            $ambilBarang = $this->barangMasukModel->dataBarangByID($brg_id);
            $rakBarang = $this->barangModel->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')->where('tb_barang.barang_id', $ambilBarang['barang_id'])->first();
            $sumDataBarang = $this->barangMasukModel->selectSum('stok')->where('barang_id', $ambilBarang['barang_id'])->first();
            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'nama_barang' => $ambilBarang['nama_barang'],
                'harga_jual' => $ambilBarang['harga_jual'],
                'harga_beli' => $ambilBarang['harga_beli'],
                'jumlah' => $ambilBarang['jumlah'],
                'stok' => $ambilBarang['stok'],
                'kapasitas' => $rakBarang['kapasitas'],
                'stokNow' => $sumDataBarang['stok']
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
            $brg_id = $this->request->getVar('brg_id');
            $invoice = $this->request->getVar('invoice');
            $harga_beli = $this->request->getVar('harga_beli');
            $harga_jual = $this->request->getVar('harga_jual');
            $jumlah = $this->request->getVar('jumlah');
            $subtotal = intval($jumlah) * intval($harga_beli);

            $this->barangMasukModel->save([
                'brg_id' => $brg_id,
                'invoice' => $invoice,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'stok' => $jumlah,
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

            $this->barangMasukModel->delete($brg_id);

            $json = [
                'success' => 'Item Berhasil Dihapuskan'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function storeBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->request->getVar('invoice');
            $barang_id = $this->request->getVar('barang_id');
            $harga_beli = $this->request->getVar('harga_beli');
            $harga_jual = $this->request->getVar('harga_jual');
            $jumlah = $this->request->getVar('jumlah');
            $subtotal = intval($jumlah) * intval($harga_beli);
            $supplier_id = $this->request->getVar('supplier_id');
            $tanggal = $this->request->getVar('tanggal');

            $this->barangMasukModel->save([
                'invoice' => $invoice,
                'barang_id' => $barang_id,
                'harga_jual' => $harga_jual,
                'harga_beli' => $harga_beli,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
                'stok' => $jumlah,
                'supplier_id' => $supplier_id,
                'tanggal' => $tanggal,
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
