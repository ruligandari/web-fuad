<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>The Lost Word Adventure - <?= $title ?? '' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { primary: '#0D9488' },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0', transform: 'translateY(10px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideIn: { '0%': { transform: 'translateX(-100%)' }, '100%': { transform: 'translateX(0)' } },
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <style>
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .dark ::-webkit-scrollbar-thumb { background-color: #475569; }
        .sidebar-collapsed .sidebar { width: 5rem; }
        .sidebar-collapsed .sidebar .nav-label,
        .sidebar-collapsed .sidebar .brand-text,
        .sidebar-collapsed .sidebar .nav-text,
        .sidebar-collapsed .sidebar .logout-text { display: none; }
        .sidebar-collapsed .sidebar .nav-icon { margin: 0; }
        .sidebar-collapsed .sidebar nav a { justify-content: center; padding: 0.75rem; }
        .sidebar-collapsed .sidebar .logout-btn { justify-content: center; padding: 0.75rem; }
        .sidebar-collapsed .sidebar .logout-btn span { display: none; }
        .sidebar-collapsed .sidebar .brand { padding: 0; }
        .sidebar-collapsed .main-content { margin-left: 5rem; }
        .sidebar { transition: width 0.3s ease; }
        .main-content { transition: margin-left 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200 min-h-screen transition-colors duration-300 font-sans">

    <div class="flex h-screen overflow-hidden" id="appWrapper">

        <aside class="sidebar w-64 bg-gradient-to-b from-primary to-emerald-800 dark:from-slate-950 dark:to-slate-900 flex-shrink-0 flex flex-col z-20 shadow-xl">
            <div class="brand h-16 flex items-center justify-center border-b border-white/20 dark:border-slate-800 px-4">
                <i class="fas fa-book-open text-white text-xl mr-3"></i>
                <span class="brand-text text-lg font-bold text-white uppercase tracking-wider">SDN 1 Kadugede</span>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <div class="nav-label text-xs font-semibold text-emerald-200 dark:text-slate-400 uppercase tracking-wider mb-3 px-3">
                    Menu
                </div>

                <a href="<?= base_url('admin/soal') ?>" class="flex items-center px-3 py-2.5 rounded-lg transition-all <?= ($title == 'Data Soal') ? 'bg-white text-primary shadow-md font-bold dark:bg-slate-800 dark:text-emerald-400' : 'text-emerald-100 hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-white' ?>">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt w-6 text-center"></i>
                    <span class="nav-text font-medium ml-3">Data Soal</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/20 dark:border-slate-800">
                <button id="sidebarToggle" class="w-full flex items-center px-3 py-2.5 rounded-lg text-emerald-200 hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-white transition-colors mb-2">
                    <i class="nav-icon fas fa-fw fa-arrows-alt-h w-6 text-center"></i>
                    <span class="nav-text font-medium ml-3">Collapse</span>
                </button>
                <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="logout-btn w-full flex items-center px-3 py-2.5 rounded-lg text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-colors">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt w-6 text-center"></i>
                    <span class="logout-text font-medium ml-3">Logout</span>
                </button>
            </div>
        </aside>

        <div class="main-content flex-1 flex flex-col overflow-hidden relative z-10">
            <header class="h-16 bg-white dark:bg-slate-800 flex items-center justify-between px-6 z-20 shadow-sm border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-4">
                    <button id="mobileToggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-500 dark:text-gray-300">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">The Lost Word Adventure</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <button id="darkModeToggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors focus:outline-none text-gray-500 dark:text-gray-300">
                        <i class="fas fa-moon hidden dark:inline"></i>
                        <i class="fas fa-sun dark:hidden"></i>
                    </button>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200"><?= session()->get('nama') ?></span>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-emerald-500 flex items-center justify-center text-white font-bold shadow-sm">
                            <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 relative z-0 animate-fade-in">
                <?= $this->renderSection('content'); ?>
            </main>

            <footer class="bg-white dark:bg-slate-800 py-4 text-center text-sm z-20 mt-auto text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-slate-700">
                <span>Copyright &copy; SDN 1 Kadugede <?= date('Y') ?></span>
            </footer>
        </div>
    </div>

    <div id="logoutModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white dark:bg-slate-800 w-full max-w-md rounded-2xl shadow-2xl p-6 transform scale-100 transition-transform relative z-10 border border-gray-100 dark:border-slate-700">
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Akhiri Sesi?</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Apakah Anda yakin ingin logout dari sistem?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-medium">Batal</button>
                <a href="<?= base_url('logout') ?>" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors shadow-lg shadow-red-500/30 font-medium">Logout</a>
            </div>
        </div>
    </div>

    <script>
        const isDark = localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        const html = document.documentElement;
        if (isDark) html.classList.add('dark');

        document.getElementById('darkModeToggle').addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        const wrapper = document.getElementById('appWrapper');
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            wrapper.classList.toggle('sidebar-collapsed');
        });
        document.getElementById('mobileToggle').addEventListener('click', () => {
            wrapper.classList.toggle('sidebar-collapsed');
        });

        const logoutModal = document.getElementById('logoutModal');
        logoutModal.addEventListener('click', (e) => {
            if(e.target === logoutModal) logoutModal.classList.add('hidden');
        });
    </script>

    <?= $this->renderSection('script'); ?>
</body>
</html>
