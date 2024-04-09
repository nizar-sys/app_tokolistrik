<?php

namespace App\Models;

use CodeIgniter\Model;

class RakModel extends Model
{
    protected $table            = 'tb_rak';
    protected $primaryKey       = 'rak_id';
    protected $allowedFields    = ['rak_id', 'nama_rak', 'kapasitas', 'lokasi', 'cabang_id'];
    protected $selectedFields = [
        'tb_rak.rak_id',
        'tb_rak.nama_rak',
        'tb_rak.kapasitas',
        'tb_rak.lokasi',
        'tb_rak.cabang_id',
        'tb_cabang.cabang as nama_cabang',
    ];

    public function getRak($id = false)
    {
        $this->select($this->selectedFields)
            ->join('tb_cabang', 'tb_cabang.id = tb_rak.cabang_id', 'left')
            ->orderBy('tb_rak.rak_id', 'DESC');

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }

        if ($id == false) {
            return $this->asObject()->findAll();
        }
        return $this->where('rak_id', $id)->asObject()->first();
    }
}
