<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_rak' => 'Rak I',
                'kapasitas' => '50',
                'lokasi' => '1',
                'cabang_id' => '1'
            ],
            [
                'nama_rak' => 'Rak II',
                'kapasitas' => '30',
                'lokasi' => '2',
                'cabang_id' => '1'
            ],
            [
                'nama_rak' => 'Rak III',
                'kapasitas' => '70',
                'lokasi' => '3',
                'cabang_id' => '1'
            ],
        ];

        $this->db->table('tb_rak')->insertBatch($data);
    }
}
