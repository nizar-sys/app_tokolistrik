<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'tb_kategori';
    protected $primaryKey       = 'kategori_id';
    protected $allowedFields    = ['kategori_id', 'nama_kategori'];

    public function getKategori($id = false)
    {
        if ($id == false) {
            return $this->asObject()->findAll();
        }
        return $this->where('kategori_id', $id)->asObject()->first();
    }
}
