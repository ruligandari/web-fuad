<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SoalSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('soal')->truncate();

        $data = [
            // Level 1: 4-letter words (10 questions, each 1 word)
            ['soal' => 'Bird', 'level' => 1],
            ['soal' => 'Fish', 'level' => 1],
            ['soal' => 'Star', 'level' => 1],
            ['soal' => 'Moon', 'level' => 1],
            ['soal' => 'Tree', 'level' => 1],
            ['soal' => 'Rain', 'level' => 1],
            ['soal' => 'Snow', 'level' => 1],
            ['soal' => 'Door', 'level' => 1],
            ['soal' => 'Book', 'level' => 1],
            ['soal' => 'Hand', 'level' => 1],

            // Level 2: 5-letter words (10 questions, each 1 word)
            ['soal' => 'Apple', 'level' => 2],
            ['soal' => 'Mango', 'level' => 2],
            ['soal' => 'Grape', 'level' => 2],
            ['soal' => 'Lemon', 'level' => 2],
            ['soal' => 'House', 'level' => 2],
            ['soal' => 'Table', 'level' => 2],
            ['soal' => 'Water', 'level' => 2],
            ['soal' => 'Tiger', 'level' => 2],
            ['soal' => 'Horse', 'level' => 2],
            ['soal' => 'Earth', 'level' => 2],

            // Level 3: 6-letter words (10 questions, each 1 word)
            ['soal' => 'Banana', 'level' => 3],
            ['soal' => 'Orange', 'level' => 3],
            ['soal' => 'Flower', 'level' => 3],
            ['soal' => 'Forest', 'level' => 3],
            ['soal' => 'Silver', 'level' => 3],
            ['soal' => 'Guitar', 'level' => 3],
            ['soal' => 'Doctor', 'level' => 3],
            ['soal' => 'Summer', 'level' => 3],
            ['soal' => 'Animal', 'level' => 3],
            ['soal' => 'Planet', 'level' => 3],
        ];

        // Insert to the table
        $this->db->table('soal')->insertBatch($data);
    }
}
