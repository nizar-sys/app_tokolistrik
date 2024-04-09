<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SimpleSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('SupplierSeeder');
        $this->call('KategoriSeeder');
        $this->call('MerkSeeder');
        $this->call('RakSeeder');
        $this->call('DataBarangSeeder');
    }
}
