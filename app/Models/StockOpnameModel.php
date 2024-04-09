<?php

namespace App\Models;

use CodeIgniter\Model;

class StockOpnameModel extends Model
{
    protected $table            = 'tb_stockopname';
    protected $primaryKey       = 'so_id';
    protected $allowedFields    = ['kode_so', 'brg_id', 'barang_id', 'stock_fisik', 'selisih', 'keterangan', 'tanggal', 'user_id', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getStockOpname($id = false)
    {
        $this->select('tb_stockopname.so_id, tb_stockopname.kode_so, tb_stockopname.keterangan, tb_barang.nama_barang, tb_barangmasuk.stok, tb_stockopname.stock_fisik, tb_stockopname.selisih, tb_users.nama_lengkap, tb_stockopname.updated_at')->join('tb_barang', 'tb_stockopname.barang_id = tb_barang.barang_id')->join('tb_users', 'tb_stockopname.user_id = tb_users.user_id')->join('tb_barangmasuk', 'tb_stockopname.brg_id = tb_barangmasuk.brg_id')->orderBy('tb_stockopname.so_id', 'DESC')->asObject();

        if (session()->get('role') == 'admin') {
            $this->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')->where('tb_cabang.admin_id', session()->get('id'));
        }

        if ($id === false) {
            return $this->findAll();
        }

        return $this->where('tb_stockopname.so_id', $id)->first();
    }

    public function showDataBarang($tgl_awal, $tgl_akhir)
    {
        $this->select('tb_stockopname.so_id, tb_stockopname.kode_so, tb_stockopname.keterangan, tb_barang.nama_barang, tb_barangmasuk.stok, tb_stockopname.stock_fisik, tb_stockopname.selisih, tb_users.nama_lengkap, tb_stockopname.updated_at')
        ->join('tb_barang', 'tb_stockopname.barang_id = tb_barang.barang_id')
        ->join('tb_users', 'tb_stockopname.user_id = tb_users.user_id')
        ->join('tb_barangmasuk', 'tb_stockopname.brg_id = tb_barangmasuk.brg_id')
        ->where("tb_stockopname.tanggal BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}'");

        if (session()->get('role') == 'admin') {
            $this->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->findAll();
    }

    public function selectMaxWhereBranch() {
        $this->selectMax('kode_so', 'kode_so');
        $this->join('tb_barang', 'tb_stockopname.barang_id = tb_barang.barang_id');
        $this->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id');
        $this->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id');
        $this->where('tb_cabang.admin_id', session()->get('id'));

        return $this->first();
    }
}
