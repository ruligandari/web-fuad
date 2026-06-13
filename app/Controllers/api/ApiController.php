<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\SoalModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    protected $soalModel;

    public function __construct()
    {
        $this->soalModel = new SoalModel();
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
}
