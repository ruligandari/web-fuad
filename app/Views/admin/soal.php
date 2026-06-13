<?= $this->extend('template_tailwind'); ?>
<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "<?= session()->getFlashdata('success') ?>",
            icon: "success",
            background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#1e293b'
        });
    </script>
<?php endif ?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Data Soal</h1>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <button onclick="document.getElementById('tambahModal').classList.remove('hidden')" class="px-4 py-2 bg-primary hover:bg-emerald-600 text-white rounded-lg shadow-sm transition-all font-medium flex items-center justify-center gap-2">
            <i class="fas fa-plus"></i> Tambah Data Soal
        </button>
    </div>

    <div class="p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse" id="dataTable">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50">
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-16 text-sm">No</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-sm">Soal</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-24 text-sm">Level</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-40 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php $no = 1; foreach ($soal as $data) : ?>
                <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="py-3 px-6 text-center text-gray-500 dark:text-gray-400 text-sm"><?= $no++ ?></td>
                    <td class="py-3 px-6 text-gray-800 dark:text-gray-200 font-medium text-sm"><?= htmlspecialchars($data['soal']) ?></td>
                    <td class="py-3 px-6 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            <?= $data['level'] == 1 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300' : '' ?>
                            <?= $data['level'] == 2 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' : '' ?>
                            <?= $data['level'] == 3 ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : '' ?>">
                            Level <?= htmlspecialchars($data['level']) ?>
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center space-x-2">
                        <button onclick="document.getElementById('editModal<?= $data['id'] ?>').classList.remove('hidden')" class="w-8 h-8 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:hover:bg-indigo-500/30 dark:text-indigo-400 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteSoal(<?= $data['id'] ?>)" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-500/20 dark:hover:bg-red-500/30 dark:text-red-400 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tambahModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity overflow-y-auto">
    <div class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-2xl shadow-2xl p-6 transform scale-100 transition-transform relative z-10 border border-gray-100 dark:border-slate-700 my-8">
        <div class="flex justify-between items-center border-b border-gray-100 dark:border-slate-700 pb-4 mb-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Tambah Soal</h3>
            <button onclick="document.getElementById('tambahModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="<?= base_url('admin/soal/store') ?>" method="POST" class="space-y-4" onsubmit="return validateForm(this)">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Soal</label>
                <input type="text" name="soal" placeholder="Masukkan Soal" required class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:text-white shadow-sm transition-all">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Level</label>
                <input type="number" name="level" min="1" max="3" placeholder="Level (1-3)" required class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:text-white shadow-sm transition-all">
                <p class="text-xs text-gray-400 mt-1">Min: 1, Max: 3</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700 mt-6">
                <button type="button" onclick="document.getElementById('tambahModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-primary hover:bg-emerald-600 text-white transition-colors shadow-md shadow-emerald-500/20 font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?php foreach ($soal as $s) : ?>
<div id="editModal<?= $s['id'] ?>" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity overflow-y-auto">
    <div class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-2xl shadow-2xl p-6 transform scale-100 transition-transform relative z-10 border border-gray-100 dark:border-slate-700 my-8">
        <div class="flex justify-between items-center border-b border-gray-100 dark:border-slate-700 pb-4 mb-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Edit Soal</h3>
            <button onclick="document.getElementById('editModal<?= $s['id'] ?>').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="<?= base_url('admin/soal/update/' . $s['id']) ?>" method="POST" class="space-y-4" onsubmit="return validateForm(this)">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Soal</label>
                <input type="text" name="soal" value="<?= htmlspecialchars($s['soal']) ?>" required class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:text-white shadow-sm transition-all">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Level</label>
                <input type="number" name="level" min="1" max="3" value="<?= htmlspecialchars($s['level'] ?? '') ?>" required class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:text-white shadow-sm transition-all">
                <p class="text-xs text-gray-400 mt-1">Min: 1, Max: 3</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700 mt-6">
                <button type="button" onclick="document.getElementById('editModal<?= $s['id'] ?>').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white transition-colors shadow-md shadow-indigo-500/20 font-medium">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "processing": "Memproses...",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                    "last": "Terakhir"
                }
            },
            "dom": '<"flex items-center justify-between mb-4"l>rt<"flex items-center justify-between mt-4"ip>',
        });
    });

    function validateForm(form) {
        const level = parseInt(form.querySelector('[name="level"]').value);
        if (level < 1 || level > 3) {
            Swal.fire({
                title: 'Error',
                text: 'Level harus antara 1 - 3',
                icon: 'error',
                confirmButtonColor: '#0D9488'
            });
            return false;
        }
        return true;
    }

    function deleteSoal(id) {
        const isDark = document.documentElement.classList.contains('dark');
        Swal.fire({
            title: 'Hapus Soal?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            background: isDark ? '#1e293b' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            customClass: { popup: 'rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/soal/delete/') ?>" + id;
            }
        })
    }
</script>
<?= $this->endSection(); ?>
