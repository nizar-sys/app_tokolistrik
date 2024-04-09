<?php

namespace App\Models;

use CodeIgniter\Model;

class DataBarangModel extends Model
{
    protected $table            = 'tb_barang';
    protected $primaryKey       = 'barang_id';
    protected $allowedFields    = ['barang_id', 'nama_barang', 'deskripsi', 'merk_id', 'kategori_id', 'harga_jual', 'rak_id', 'stok_alert', 'sampul'];

    public function getBarang($id = null)
    {
        $this->select('tb_barang.*, tb_merk.merk, tb_kategori.nama_kategori, tb_rak.nama_rak, tb_cabang.cabang')
            ->join('tb_merk', 'tb_barang.merk_id = tb_merk.merk_id')
            ->join('tb_kategori', 'tb_barang.kategori_id = tb_kategori.kategori_id')
            ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
            ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
            ->orderBy('tb_barang.barang_id', 'DESC')
            ->asObject();

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        if ($id === null) {
            return $this->findAll();
        }

        return $this->where('tb_barang.barang_id', $id)->first();
    }

    // count barang berdasarkan admin_id di tb_cabang
    public function countBarang()
    {
        $this
            ->join('tb_rak', 'tb_barang.rak_id = tb_rak.rak_id')
            ->join('tb_cabang', 'tb_rak.cabang_id = tb_cabang.id')
            ->orderBy('tb_barang.barang_id', 'DESC')
            ->asObject();

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        return $this->countAllResults();
    }
}
