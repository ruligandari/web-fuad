<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'soal' => [
                'type' => 'TEXT',
            ],
            'level' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('soal');
    }

    public function down()
    {
        $this->forge->dropTable('soal');
    }
}
