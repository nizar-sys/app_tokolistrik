<?php

namespace App\Models;

use CodeIgniter\Model;

class MerkModel extends Model
{
    protected $table            = 'tb_merk';
    protected $primaryKey       = 'merk_id';
    protected $allowedFields    = ['merk_id', 'merk'];

    public function getMerk($id = false)
    {
        if ($id == false) {
            return $this->asObject()->findAll();
        }
        return $this->where('merk_id', $id)->asObject()->first();
    }
}
