<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Models\BarangMasukModel;
use App\Models\StockOpnameModel;
use App\Models\BarangKeluarModel;
use App\Controllers\BaseController;

class CetakController extends BaseController
{
    protected $barangMasukModel;
    protected $barangKeluarModel;
    protected $stockOpnameModel;
    protected $authModel;
    protected $supplierModel;

    public function __construct()
    {
        $this->barangMasukModel = new BarangMasukModel();
        $this->barangKeluarModel = new BarangKeluarModel();
        $this->stockOpnameModel = new StockOpnameModel();
        $this->authModel = new UserModel();
        $this->supplierModel = new SupplierModel();
    }

    public function indexBarangMasuk()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Laporan Barang Masuk',
            'account' => $this->authModel->getUser(session()->get('id')),
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
        ];

        return view('cetak/barangmasuk/index', $data);
    }

    public function dataBarangMasuk()
    {
        if ($this->request->isAJAX()) {
            $tgl_awal = $this->request->getVar('tgl_awal');
            $tgl_akhir = $this->request->getVar('tgl_akhir');
            $getBarang = $this->barangMasukModel->showDataBarang($tgl_awal, $tgl_akhir);
            if ($getBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'dataBarangMasuk' => $getBarang
                ];

                $json = [
                    'success' => view('cetak/barangmasuk/datatable', $data),
                    'data' => $getBarang
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function printBarangMasuk()
    {
        $mpdf = new \Mpdf\Mpdf();

        $tgl_awal = $this->request->getVar('tgl_awal');
        $tgl_akhir = $this->request->getVar('tgl_akhir');

        if ($tgl_awal > $tgl_akhir) {
            session()->setFlashdata('error', 'Mohon Memilih Tanggal Yang Benar.');
            return redirect()->to('cetak/barangmasuk');
        } else {
            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'result' => $this->barangMasukModel->showDataBarang($tgl_awal, $tgl_akhir)
            ];

            if ($data['result'] == null) {
                session()->setFlashdata('error', 'Data Tidak Ditemukan.');
                return redirect()->to('cetak/barangmasuk');
            } else {
                // Generate the PDF
                $html = view('cetak/barangmasuk/printbarangmasuk', $data);
                $mpdf->WriteHTML($html);
                $mpdf->Output('laporan-data-barang-masuk.pdf', 'D');
            }
        }
    }

    public function indexBarangKeluar()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Laporan Barang Keluar',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        // dd($this->barangKeluarModel->showDataBarang('2023-05-06', '2023-05-06'));

        return view('cetak/barangkeluar/index', $data);
    }

    public function dataBarangKeluar()
    {
        if ($this->request->isAJAX()) {
            $tgl_awal = $this->request->getVar('tgl_awal');
            $tgl_akhir = $this->request->getVar('tgl_akhir');
            $getBarang = $this->barangKeluarModel->showDataBarang($tgl_awal, $tgl_akhir);
            if ($getBarang == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'dataBarangKeluar' => $getBarang
                ];

                $json = [
                    'success' => view('cetak/barangkeluar/datatable', $data),
                    'data' => $getBarang
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function printBarangKeluar()
    {
        $mpdf = new \Mpdf\Mpdf();

        $tgl_awal = $this->request->getVar('tgl_awal');
        $tgl_akhir = $this->request->getVar('tgl_akhir');

        if ($tgl_awal > $tgl_akhir) {
            session()->setFlashdata('error', 'Mohon Memilih Tanggal Yang Benar.');
            return redirect()->to('cetak/barangkeluar');
        } else {
            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'result' => $this->barangKeluarModel->showDataBarang($tgl_awal, $tgl_akhir)
            ];

            if ($data['result'] == null) {
                session()->setFlashdata('error', 'Data Tidak Ditemukan.');
                return redirect()->to('cetak/barangkeluar');
            } else {
                // Generate the PDF
                $html = view('cetak/barangkeluar/printbarangkeluar', $data);
                $mpdf->WriteHTML($html);
                $mpdf->Output('laporan-data-barang-keluar.pdf', 'D');
            }
        }
    }

    public function indexStockOpname()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Laporan Stockopname',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        return view('cetak/stockopname/index', $data);
    }

    public function dataStockOpname()
    {
        if ($this->request->isAJAX()) {
            $tgl_awal = $this->request->getVar('tgl_awal');
            $tgl_akhir = $this->request->getVar('tgl_akhir');
            $getBarang = $this->stockOpnameModel->showDataBarang($tgl_awal, $tgl_akhir);
            if ($getBarang == null) {
                $json = [
                    'error' => 'Data Stockopname Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'dataStockopname' => $getBarang
                ];

                $json = [
                    'success' => view('cetak/stockopname/datatable', $data),
                    'data' => $getBarang
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function printStockOpname()
    {
        $mpdf = new \Mpdf\Mpdf();

        $tgl_awal = $this->request->getVar('tgl_awal');
        $tgl_akhir = $this->request->getVar('tgl_akhir');

        if ($tgl_awal > $tgl_akhir) {
            session()->setFlashdata('error', 'Mohon Memilih Tanggal Yang Benar.');
            return redirect()->to('cetak/stockopname');
        } else {
            $data = [
                'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                'result' => $this->stockOpnameModel->showDataBarang($tgl_awal, $tgl_akhir)
            ];

            if ($data['result'] == null) {
                session()->setFlashdata('error', 'Data Tidak Ditemukan.');
                return redirect()->to('cetak/stockopname');
            } else {
                // Generate the PDF
                $html = view('cetak/stockopname/printstockopname', $data);
                $mpdf->WriteHTML($html);
                $mpdf->Output('laporan-data-stockopname.pdf', 'D');
            }
        }
    }

    public function indexSupplier()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Laporan Supplier',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        return view('cetak/supplier/index', $data);
    }

    public function dataSupplier()
    {
        if ($this->request->isAJAX()) {
            $getSupplier = $this->supplierModel->getSupplier();
            if ($getSupplier == null) {
                $json = [
                    'error' => 'Data Barang Tidak Ditemukan!'
                ];
            } else {
                $data = [
                    'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
                    'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
                    'dataSupplier' => $getSupplier
                ];

                $json = [
                    'success' => view('cetak/supplier/datatable', $data),
                    'data' => $getSupplier
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }

    public function printSupplier()
    {
        $mpdf = new \Mpdf\Mpdf();

        $data = [
            'result' => $this->supplierModel->getSupplier()
        ];

        if ($data['result'] == null) {
            session()->setFlashdata('error', 'Data Tidak Ditemukan.');
            return redirect()->to('cetak/supplier');
        } else {
            // Generate the PDF
            $html = view('cetak/supplier/printsupplier', $data);
            $mpdf->WriteHTML($html);
            $mpdf->Output('laporan-data-supplier.pdf', 'D');
        }
    }
}
