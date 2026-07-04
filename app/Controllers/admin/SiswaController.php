<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class SiswaController extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Siswa',
            'siswa' => $this->siswaModel->orderBy('id', 'DESC')->findAll()
        ];

        return view('admin/siswa', $data);
    }

    public function delete($id)
    {
        $this->siswaModel->delete($id);
        session()->setFlashdata('success', 'Data siswa berhasil dihapus');
        return redirect()->to(base_url('admin/siswa'));
    }
}
