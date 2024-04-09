<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataBarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_barang' => 'Lampu philips',
                'deskripsi' => 'Lampu philips',
                'merk_id' => '1',
                'kategori_id' => '1',
                'harga_jual' => '25000',
                'rak_id' => '1',
                'stok_alert' => '2'
            ],
            [
                'nama_barang' => 'Lampu Hannoschs',
                'deskripsi' => 'Lampu Hannoschs',
                'merk_id' => '1',
                'kategori_id' => '2',
                'harga_jual' => '27000',
                'rak_id' => '3',
                'stok_alert' => '3'
            ],
            [
                'nama_barang' => 'Lampu philips',
                'deskripsi' => 'Lampu philips',
                'merk_id' => '2',
                'kategori_id' => '1',
                'harga_jual' => '20000',
                'rak_id' => '3',
                'stok_alert' => '4'
            ],
            [
                'nama_barang' => 'Stecker Broco',
                'deskripsi' => 'Stecker Broco',
                'merk_id' => '3',
                'kategori_id' => '1',
                'harga_jual' => '30000',
                'rak_id' => '2',
                'stok_alert' => '2'
            ],
            [
                'nama_barang' => 'Stecker Broco',
                'deskripsi' => 'Stecker Broco',
                'merk_id' => '1',
                'kategori_id' => '1',
                'harga_jual' => '25000',
                'rak_id' => '1',
                'stok_alert' => '5'
            ],
        ];

        $this->db->table('tb_barang')->insertBatch($data);
    }
}
