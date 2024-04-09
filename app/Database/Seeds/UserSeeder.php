<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_lengkap' => 'Owner',
                'alamat' => 'Jl Medan Merdeka No.6',
                'tanggal_lahir' => '1998-09-13',
                'username' => 'owner',
                'email' => 'owner01@gmail.com',
                'password' => password_hash('owner01', PASSWORD_DEFAULT),
                'avatar' => 'user-default.png',
                'role' => 'owner',
                'is_active' => 1,
            ],
            [
                'nama_lengkap' => 'Bayu Antoneo',
                'alamat' => 'Jl Papua Raya No.10',
                'tanggal_lahir' => '1988-07-15',
                'username' => 'bayu',
                'email' => 'admin01@gmail.com',
                'password' => password_hash('admin01', PASSWORD_DEFAULT),
                'avatar' => 'user-default.png',
                'role' => 'admin',
                'is_active' => 1,
            ],
            [
                'nama_lengkap' => 'Bayu Antoneos',
                'alamat' => 'Jl Papua Raya No.10',
                'tanggal_lahir' => '1988-07-15',
                'username' => 'bayu1',
                'email' => 'admin02@gmail.com',
                'password' => password_hash('admin02', PASSWORD_DEFAULT),
                'avatar' => 'user-default.png',
                'role' => 'admin',
                'is_active' => 1,
            ],
        ];

        // Using Query Builder
        $this->db->table('tb_users')->insertBatch($data);
    }
}
