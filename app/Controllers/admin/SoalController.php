<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SoalModel;

class SoalController extends BaseController
{
    protected $soalModel;

    public function __construct()
    {
        $this->soalModel = new SoalModel();
    }
    public function index()
    {
        $soal = $this->soalModel->orderBy('id', 'ASC')->findAll();

        $data = [
            'title' => 'Data Soal',
            'soal' => $soal,
        ];

        return view('admin/soal', $data);
    }

    public function store()
    {
        $data = [
            'soal' => $this->request->getPost('soal'),
            'level' => $this->request->getPost('level'),
        ];

        $this->soalModel->insert($data);

        return redirect()->to('/admin/soal')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $data = [
            'soal' => $this->request->getPost('soal'),
            'level' => $this->request->getPost('level'),
        ];

        $this->soalModel->update($id, $data);

        return redirect()->to('/admin/soal')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $this->soalModel->delete($id);

        return redirect()->to('/admin/soal')->with('success', 'Data berhasil dihapus');
    }
}
