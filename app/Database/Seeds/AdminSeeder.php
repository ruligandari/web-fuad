<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('admin')->insert([
            'username' => 'admin',
            'password' => password_hash('password', PASSWORD_BCRYPT),
        ]);
    }
}
