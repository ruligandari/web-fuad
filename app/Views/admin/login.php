<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Lost Word Adventure - <?= $title ?? 'Login' ?></title>
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
                        'float': 'float 3s ease-in-out infinite',
                        'float-delay': 'float 3s ease-in-out 1.5s infinite',
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'gradient': 'gradient 8s ease infinite',
                    },
                    keyframes: {
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-20px)' } },
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        gradient: { '0%, 100%': { backgroundPosition: '0% 50%' }, '50%': { backgroundPosition: '100% 50%' } },
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }
        .bg-animated {
            background: linear-gradient(-45deg, #0D9488, #14B8A6, #2DD4BF, #5EEAD4);
            background-size: 400% 400%;
            animation: gradient 8s ease infinite;
        }
        .dark .bg-animated {
            background: linear-gradient(-45deg, #0F3D38, #0A5C52, #0D7A6E, #145C52);
            background-size: 400% 400%;
            animation: gradient 8s ease infinite;
        }
        .particle {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }
        .dark .particle { opacity: 0.08; }
        .spinner { display: none; }
        form.submitting .spinner { display: inline-block; }
        form.submitting .btn-text { display: none; }
        form.submitting button { pointer-events: none; opacity: 0.8; }
    </style>
</head>
<body class="bg-animated text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center font-sans relative overflow-hidden">

    <div id="particles"></div>

    <button id="darkModeToggle" class="absolute top-6 right-6 p-3 rounded-full glass hover:bg-white/40 dark:hover:bg-white/10 transition-all z-20 animate-fade-in">
        <i class="fas fa-moon text-gray-800 dark:text-gray-300 hidden dark:inline"></i>
        <i class="fas fa-sun text-yellow-500 dark:hidden"></i>
    </button>

    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                title: "Oops!",
                text: "<?= session()->getFlashdata('error') ?>",
                icon: "error",
                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#374151'
            });
        </script>
    <?php endif ?>

    <div class="container mx-auto px-4 z-10 relative animate-slide-up">
        <div class="max-w-md mx-auto">
            <div class="glass rounded-3xl overflow-hidden p-8 sm:p-10">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-emerald-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-500/30 animate-float">
                        <i class="fas fa-book-open text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">The Lost Word Adventure</h1>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">Selamat Datang, Silahkan Login Untuk Melanjutkan!</p>
                </div>

                <form method="POST" action="<?= base_url('auth') ?>" class="space-y-6" id="loginForm">
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="username" class="w-full pl-10 pr-4 py-3 bg-white/60 dark:bg-slate-800/60 border border-white/40 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-emerald-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" placeholder="Masukkan Username" required>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" class="w-full pl-10 pr-4 py-3 bg-white/60 dark:bg-slate-800/60 border border-white/40 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-emerald-500 focus:border-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" placeholder="Password" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-primary to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 transform transition hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span class="btn-text">Login</span>
                        <svg class="spinner w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                </form>

                <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
                    Copyright &copy; SDN 1 Kadugede <?= date('Y') ?>
                </div>
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

        const letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        const particles = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            const span = document.createElement('span');
            span.className = 'particle';
            span.textContent = letters[Math.floor(Math.random() * letters.length)];
            span.style.left = Math.random() * 100 + '%';
            span.style.top = Math.random() * 100 + '%';
            span.style.animationDelay = Math.random() * 6 + 's';
            span.style.animationDuration = (4 + Math.random() * 4) + 's';
            span.style.fontSize = (1 + Math.random() * 2) + 'rem';
            particles.appendChild(span);
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            this.classList.add('submitting');
        });
    </script>
</body>
</html>
