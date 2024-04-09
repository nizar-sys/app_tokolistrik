<?php

namespace App\Models;

use CodeIgniter\Model;

class CabangModel extends Model
{
    protected $table            = 'tb_cabang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $selectedFields = [
        'tb_cabang.id',
        'tb_cabang.cabang',
        'tb_cabang.alamat',
        'tb_cabang.owner_id',
        'tb_cabang.admin_id',
        'owner.nama_lengkap AS nama_owner',
        'admin.nama_lengkap AS nama_admin'
    ];
    protected $allowedFields    = ['cabang', 'alamat', 'owner_id', 'admin_id'];
    
    public function getCabang($id = false)
    {
        $this->select($this->selectedFields)
             ->join('tb_users AS owner', 'owner.user_id = tb_cabang.owner_id', 'left')
             ->join('tb_users AS admin', 'admin.user_id = tb_cabang.admin_id', 'left')
             ->orderBy('tb_cabang.id', 'DESC');

        if (session()->get('role') == 'admin') {
            $this->where('tb_cabang.admin_id', session()->get('id'));
        }
    
        if ($id !== false) {
            $this->where('tb_cabang.id', $id);
            return $this->asObject()->first();
        } else {
            return $this->asObject()->findAll();
        }
    }
}
