<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table            = 'tb_suppliers';
    protected $primaryKey       = 'supplier_id';
    protected $allowedFields    = ['supplier_id', 'nama_supplier', 'no_telpon', 'alamat'];

    public function getSupplier($id = false)
    {
        if ($id == false) {
            return $this->asObject()->findAll();
        }
        return $this->where('supplier_id', $id)->asObject()->first();
    }
}
