<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MerkSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'merk' => 'Broco',
            ],
            [
                'merk' => 'Philips',
            ],
            [
                'merk' => 'Tin',
            ],
        ];

        $this->db->table('tb_merk')->insertBatch($data);
    }
}
