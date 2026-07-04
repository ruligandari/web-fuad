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
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Data Nilai Siswa</h1>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden mb-8">
    <div class="p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse" id="dataTable">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50">
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-16 text-sm">No</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-sm">Nama Siswa</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-24 text-sm">Level</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-32 text-sm">Score</th>
                    <th class="py-3 px-6 font-semibold text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-slate-600 text-center w-32 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                <?php $no = 1; foreach ($siswa as $data) : ?>
                <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="py-3 px-6 text-center text-gray-500 dark:text-gray-400 text-sm"><?= $no++ ?></td>
                    <td class="py-3 px-6 text-gray-800 dark:text-gray-200 font-medium text-sm"><?= htmlspecialchars($data['nama']) ?></td>
                    <td class="py-3 px-6 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            <?= $data['level'] == 1 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300' : '' ?>
                            <?= $data['level'] == 2 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' : '' ?>
                            <?= $data['level'] == 3 ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : '' ?>">
                            Level <?= htmlspecialchars($data['level']) ?>
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center text-gray-800 dark:text-gray-200 font-bold text-sm">
                        <?= htmlspecialchars($data['score']) ?>
                    </td>
                    <td class="py-3 px-6 text-center space-x-2">
                        <button onclick="deleteSiswa(<?= $data['id'] ?>)" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-500/20 dark:hover:bg-red-500/30 dark:text-red-400 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

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

    function deleteSiswa(id) {
        const isDark = document.documentElement.classList.contains('dark');
        Swal.fire({
            title: 'Hapus Data Siswa?',
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
                window.location.href = "<?= base_url('admin/siswa/delete/') ?>" + id;
            }
        })
    }
</script>
<?= $this->endSection(); ?>
