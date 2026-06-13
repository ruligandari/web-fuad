<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\SoalModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    protected $soalModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->soalModel = new SoalModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $data = $this->soalModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON($data);
    }

    public function readSoal()
    {
        $data = $this->soalModel->orderBy('id', 'DESC')->findAll();

        return $this->response->setJSON($data);
    }

    public function readSoalByLevel($level)
    {
        $data = $this->soalModel->where('level', $level)->findAll();

        if ($data) {
            shuffle($data);
            return $this->response->setJSON($data[0]);
        }

        return $this->response->setJSON([
            'message' => 'Data tidak ditemukan'
        ]);
    }

    public function submitScore()
    {
        $json = $this->request->getJSON(true);

        if ($json) {
            $nama  = $json['nama'] ?? null;
            $level = $json['level'] ?? null;
            $score = $json['score'] ?? null;
        } else {
            $nama  = $this->request->getPost('nama');
            $level = $this->request->getPost('level');
            $score = $this->request->getPost('score');
        }

        if (!$nama || !$level || !$score) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mohon lengkapi data: nama, level, score'
            ]);
        }

        try {
            $this->siswaModel->insert([
                'nama'  => $nama,
                'level' => $level,
                'score' => $score,
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
