<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CabangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'cabang' => 'Cabang 1',
                'alamat' => 'Jl. Cabang 1',
                'owner_id' => 2,
                'admin_id' => 3,
            ],
        ];

        // Using Query Builder
        $this->db->table('tb_cabang')->insertBatch($data);
    }
}
