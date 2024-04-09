<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $data = [
                'nama_supplier' => $faker->name(),
                'no_telpon'    => $faker->phoneNumber(),
                'alamat' => $faker->streetAddress(),
            ];

            // Using Query Builder
            $this->db->table('tb_suppliers')->insert($data);
        }
    }
}
