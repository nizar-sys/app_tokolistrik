<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['user_id', 'nama_lengkap', 'alamat', 'tanggal_lahir', 'username', 'email', 'password', 'avatar', 'role', 'is_active'];

    public function getUser($id = false)
    {
        if ($id == false) {
            return $this->asObject()->findAll();
        }
        return $this->where('user_id', $id)->asObject()->first();
    }

    public function getOwnersAndAdmins()
    {
        return $this->whereIn('role', ['owner', 'admin'])->asObject()->findAll();
    }
}
