<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Lampu'
            ],
            [
                'nama_kategori' => 'Stecker',
            ],
        ];

        $this->db->table('tb_kategori')->insertBatch($data);
    }
}
