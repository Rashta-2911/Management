<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Pojok Hunian</title>
    <meta name="description" content="Masuk ke dashboard Pojok Hunian untuk mengelola properti indekos Anda dengan mudah.">
    <link rel="icon" href="{{ asset('images/Logo Kos.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy: #1E2A45;
            --navy-light: #2A3A5C;
            --navy-dark: #151E33;
            --gold: #F5B731;
            --gold-light: #FDE68A;
            --gold-hover: #E5A820;
            --brick: #A0522D;
            --brick-light: #C4734A;
            --cream: #FAF8F5;
            --white: #FFFFFF;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background: var(--cream);
            color: var(--gray-800);
            overflow: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ─── Left Branding Panel ─── */
        .brand-panel {
            flex: 0 0 45%;
            background: linear-gradient(160deg, var(--navy) 0%, var(--navy-dark) 60%, #0F1520 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 3rem;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245, 183, 49, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatGlow 8s ease-in-out infinite;
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(160, 82, 45, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatGlow 10s ease-in-out infinite reverse;
        }

        @keyframes floatGlow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -30px) scale(1.1); }
        }

        /* Geometric decorations */
        .geo-shape {
            position: absolute;
            border: 1px solid rgba(245, 183, 49, 0.1);
            border-radius: 12px;
        }

        .geo-1 {
            width: 120px; height: 120px;
            top: 8%; left: 8%;
            transform: rotate(15deg);
            animation: geoFloat 12s ease-in-out infinite;
        }
        .geo-2 {
            width: 80px; height: 80px;
            bottom: 15%; right: 10%;
            transform: rotate(-20deg);
            animation: geoFloat 9s ease-in-out infinite reverse;
        }
        .geo-3 {
            width: 60px; height: 60px;
            top: 60%; left: 5%;
            transform: rotate(45deg);
            border-color: rgba(160, 82, 45, 0.12);
            animation: geoFloat 14s ease-in-out infinite;
        }

        @keyframes geoFloat {
            0%, 100% { transform: rotate(15deg) translateY(0); opacity: 0.5; }
            50% { transform: rotate(25deg) translateY(-15px); opacity: 1; }
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            filter: drop-shadow(0 8px 32px rgba(245, 183, 49, 0.25));
            animation: logoFloat 6s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .brand-title .text-gold { color: var(--gold); }
        .brand-title .text-white { color: var(--white); }

        .brand-tagline {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.55);
            font-weight: 400;
            line-height: 1.6;
            max-width: 320px;
            margin: 0 auto 3rem;
        }

        /* Feature list */
        .brand-features {
            list-style: none;
            text-align: left;
            max-width: 300px;
            margin: 0 auto;
        }

        .brand-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            font-weight: 400;
        }

        .brand-features li .feat-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 10px;
            background: rgba(245, 183, 49, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.1rem;
        }

        /* ─── Right Form Panel ─── */
        .form-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: var(--white);
            position: relative;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
            animation: fadeInRight 0.8s ease-out 0.2s both;
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Mobile logo (hidden on desktop) */
        .mobile-brand {
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 2rem;
        }
        .mobile-brand img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }
        .mobile-brand-text {
            font-size: 1.125rem;
            font-weight: 700;
        }
        .mobile-brand-text .text-gold { color: var(--gold); }
        .mobile-brand-text .text-navy { color: var(--navy); }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.375rem;
        }

        .form-header p {
            font-size: 0.875rem;
            color: var(--gray-400);
            margin-bottom: 2rem;
        }

        /* ─── Tab Switcher ─── */
        .tab-container {
            display: flex;
            background: var(--gray-50);
            border-radius: 14px;
            padding: 5px;
            margin-bottom: 1.75rem;
            position: relative;
            border: 1px solid var(--gray-100);
        }

        .tab-slider {
            position: absolute;
            top: 5px;
            left: 5px;
            width: calc(50% - 5px);
            height: calc(100% - 10px);
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-slider.right {
            transform: translateX(100%);
        }

        .tab-btn {
            flex: 1;
            padding: 12px 16px;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-400);
            cursor: pointer;
            position: relative;
            z-index: 1;
            border-radius: 10px;
            transition: color 0.3s ease;
        }

        .tab-btn.active {
            color: var(--navy);
        }

        .tab-btn .tab-icon {
            margin-right: 6px;
            font-size: 1rem;
        }

        /* ─── Tab Description ─── */
        .tab-description {
            font-size: 0.8125rem;
            color: var(--gray-400);
            margin-bottom: 1.5rem;
            line-height: 1.5;
            min-height: 40px;
            transition: opacity 0.2s ease;
        }

        /* ─── Form Fields ─── */
        .field-group {
            margin-bottom: 1.25rem;
        }

        .field-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.5rem;
        }

        .field-input-wrapper {
            position: relative;
        }

        .field-input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-300);
            font-size: 1.15rem;
            transition: color 0.2s ease;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1.5px solid var(--gray-200);
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--gray-800);
            background: var(--white);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-input::placeholder {
            color: var(--gray-300);
        }

        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(245, 183, 49, 0.15);
        }

        .field-input:focus ~ .input-icon,
        .field-input:focus + .input-icon {
            color: var(--gold);
        }

        .field-input-wrapper:focus-within .input-icon {
            color: var(--gold);
        }

        .field-error {
            font-size: 0.75rem;
            color: #EF4444;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ─── Submit Button ─── */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--white);
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-hover) 100%);
            transition: left 0.4s ease;
            z-index: 0;
        }

        .btn-submit:hover::before {
            left: 0;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(30, 42, 69, 0.3);
            color: var(--navy);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit span {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* ─── Register Link ─── */
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--gray-400);
        }

        .register-link a {
            color: var(--gold-hover);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: color 0.2s ease;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
        }

        .register-link a:hover {
            color: var(--gold);
        }

        .register-link a:hover::after {
            width: 100%;
        }

        /* ─── Footer ─── */
        .form-footer {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.75rem;
            color: var(--gray-300);
            white-space: nowrap;
        }

        /* ─── Responsive ─── */
        @media (max-width: 900px) {
            .brand-panel {
                display: none;
            }
            .form-panel {
                padding: 2rem 1.5rem;
            }
            .mobile-brand {
                display: flex;
            }
        }

        @media (max-width: 480px) {
            .form-wrapper {
                max-width: 100%;
            }
            .form-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        {{-- ── Left Branding Panel ── --}}
        <div class="brand-panel">
            <div class="geo-shape geo-1"></div>
            <div class="geo-shape geo-2"></div>
            <div class="geo-shape geo-3"></div>

            <div class="brand-content">
                <div class="brand-logo">
                    <img src="{{ asset('images/Logo Kos.png') }}" alt="Logo Pojok Hunian">
                </div>

                <h2 class="brand-title">
                    <span class="text-gold">Pojok</span>
                    <span class="text-white">Hunian</span>
                </h2>

                <p class="brand-tagline">
                    Kelola indekos Anda dengan mudah, cepat, dan terorganisir dalam satu platform.
                </p>

                <ul class="brand-features">
                    <li>
                        <span class="feat-icon"><i class="ti ti-building"></i></span>
                        Manajemen properti & kamar terpusat
                    </li>
                    <li>
                        <span class="feat-icon"><i class="ti ti-users"></i></span>
                        Kelola data penghuni & kontrak sewa
                    </li>
                    <li>
                        <span class="feat-icon"><i class="ti ti-report-money"></i></span>
                        Pantau tagihan & pembayaran otomatis
                    </li>
                    <li>
                        <span class="feat-icon"><i class="ti ti-chart-bar"></i></span>
                        Laporan pendapatan real-time
                    </li>
                </ul>
            </div>
        </div>

        {{-- ── Right Form Panel ── --}}
        <div class="form-panel">
            <div class="form-wrapper">
                {{-- Mobile brand (shown on small screens) --}}
                <div class="mobile-brand">
                    <img src="{{ asset('images/Logo Kos.png') }}" alt="Logo">
                    <span class="mobile-brand-text">
                        <span class="text-gold">Pojok</span><span class="text-navy">Hunian</span>
                    </span>
                </div>

                <div class="form-header">
                    <h1>Selamat Datang 👋</h1>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                {{-- Tab Switcher --}}
                <div class="tab-container">
                    <div class="tab-slider" id="tab-slider"></div>
                    <button type="button" id="tab-admin" class="tab-btn active" onclick="switchTab('admin')">
                        <i class="ti ti-shield-check tab-icon"></i>Admin
                    </button>
                    <button type="button" id="tab-pemilik" class="tab-btn" onclick="switchTab('pemilik')">
                        <i class="ti ti-home-2 tab-icon"></i>Pemilik
                    </button>
                </div>

                {{-- Tab Description --}}
                <p id="tab-desc" class="tab-description">
                    Masuk sebagai Admin untuk mengelola seluruh sistem boarding house.
                </p>

                {{-- Login Form --}}
                <form method="POST" action="/login" autocomplete="on">
                    @csrf
                    <input type="hidden" id="role-input" name="role" value="admin">

                    <div class="field-group">
                        <label class="field-label" for="email-input">Alamat Email</label>
                        <div class="field-input-wrapper">
                            <input type="email"
                                id="email-input"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Budi@gmail.com"
                                class="field-input"
                                autocomplete="email"
                                required>
                            <i class="ti ti-mail input-icon"></i>
                        </div>
                        @error('email')
                            <p class="field-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="password-input">Kata Sandi</label>
                        <div class="field-input-wrapper">
                            <input type="password"
                                id="password-input"
                                name="password"
                                placeholder="••••••••"
                                class="field-input"
                                autocomplete="current-password"
                                required>
                            <i class="ti ti-lock input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" id="btn-login" class="btn-submit">
                        <span>
                            <i class="ti ti-login"></i>
                            Masuk sebagai Admin
                        </span>
                    </button>
                </form>
                <div class="register-link" id="register-section" style="display: block;">
                    <p>
                        Belum punya akun Admin?
                        <a id="register-link" href="/admin/register">Daftar sebagai Admin</a>
                    </p>
                </div>
            </div>

            <div class="form-footer">
                &copy; {{ date('Y') }} Pojok Hunian — Sistem Manajemen Indekos
            </div>
        </div>
    </div>

    <script>
        let activeRole = 'admin';

        function switchTab(role) {
            activeRole = role;

            const adminTab = document.getElementById('tab-admin');
            const pemilikTab = document.getElementById('tab-pemilik');
            const slider = document.getElementById('tab-slider');
            const desc = document.getElementById('tab-desc');
            const btn = document.getElementById('btn-login');
            const roleInput = document.getElementById('role-input');
            const registerSection = document.getElementById('register-section');

            // Animate description
            desc.style.opacity = '0';
            setTimeout(() => {
                if (role === 'admin') {
                    slider.classList.remove('right');
                    adminTab.classList.add('active');
                    pemilikTab.classList.remove('active');
                    desc.textContent = 'Masuk sebagai Admin untuk mengelola seluruh sistem boarding house.';
                    btn.innerHTML = '<span><i class="ti ti-login"></i> Masuk sebagai Admin</span>';
                    if(registerSection) registerSection.style.display = 'block';
                } else {
                    slider.classList.add('right');
                    pemilikTab.classList.add('active');
                    adminTab.classList.remove('active');
                    desc.textContent = 'Masuk sebagai Pemilik untuk mengelola properti dan penyewa Anda.';
                    btn.innerHTML = '<span><i class="ti ti-login"></i> Masuk sebagai Pemilik</span>';
                    if(registerSection) registerSection.style.display = 'none';
                }
                desc.style.opacity = '1';
            }, 150);

            roleInput.value = role;
        }
    </script>

</body>
</html>