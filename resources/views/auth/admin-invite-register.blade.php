<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin — Pojok Hunian</title>
    <meta name="description" content="Daftar sebagai Admin Pojok Hunian melalui undangan.">
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
            --cream: #FAF8F5;
            --white: #FFFFFF;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-700: #374151;
            --gray-800: #1F2937;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background: var(--cream);
            color: var(--gray-800);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-card {
            width: 100%;
            max-width: 480px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 10px 15px -3px rgba(0,0,0,0.08);
            padding: 3rem;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
        }

        .card-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.375rem;
        }

        .card-header p {
            font-size: 0.875rem;
            color: var(--gray-400);
        }

        .badge-admin {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: var(--gold);
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Error State */
        .error-container {
            text-align: center;
            padding: 2rem 0;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #FEF2F2;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #EF4444;
        }

        .error-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .error-message {
            font-size: 0.875rem;
            color: var(--gray-400);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Form */
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

        .field-input-wrapper:focus-within .input-icon {
            color: var(--gold);
        }

        .field-input.readonly {
            background: var(--gray-50);
            color: var(--gray-500);
            cursor: not-allowed;
        }

        .field-error {
            font-size: 0.75rem;
            color: #EF4444;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

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

        .btn-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 24px;
            background: var(--gray-100);
            color: var(--gray-700);
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .btn-link:hover {
            background: var(--gray-200);
            color: var(--navy);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--gray-400);
        }

        .login-link a {
            color: var(--gold-hover);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: var(--gold);
        }

        /* Success Alert */
        .success-alert {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            color: #166534;
        }

        .success-alert i {
            font-size: 1.25rem;
            color: #22C55E;
        }

        .invite-info {
            background: var(--gray-50);
            border: 1px solid var(--gray-100);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 1.5rem;
            font-size: 0.8125rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .invite-info i {
            font-size: 1.1rem;
            color: var(--gold);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="card-header">
            <div class="card-logo">
                <img src="{{ asset('images/Logo Kos.png') }}" alt="Logo Pojok Hunian">
            </div>
            <span class="badge-admin">
                <i class="ti ti-shield-check"></i> Registrasi {{ ucfirst($invitation->role ?? 'Admin') }}
            </span>
            <h1>Buat Akun {{ ucfirst($invitation->role ?? 'Admin') }}</h1>
            <p>Daftar melalui undangan dari administrator</p>
        </div>

        @if ($error)
            {{-- Error State --}}
            <div class="error-container">
                <div class="error-icon">
                    <i class="ti ti-alert-triangle"></i>
                </div>
                <h2 class="error-title">Akses Ditolak</h2>
                <p class="error-message">{{ $error }}</p>
                <a href="/login" class="btn-link">
                    <i class="ti ti-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        @else
            {{-- Registration Form --}}
            @if (session('success'))
                <div class="success-alert">
                    <i class="ti ti-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="invite-info">
                <i class="ti ti-ticket"></i>
                Anda diundang oleh <strong>{{ $invitation->inviter->nama ?? 'Admin' }}</strong>
                @if ($invitation->email)
                    untuk email <strong>{{ $invitation->email }}</strong>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.invite.register.submit') }}" autocomplete="on">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field-group">
                    <label class="field-label" for="nama-input">Nama Lengkap</label>
                    <div class="field-input-wrapper">
                        <input type="text"
                            id="nama-input"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap"
                            class="field-input"
                            autocomplete="name"
                            required
                            autofocus>
                        <i class="ti ti-user input-icon"></i>
                    </div>
                    @error('nama')
                        <p class="field-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="email-input">Alamat Email</label>
                    <div class="field-input-wrapper">
                        @if ($invitation->email)
                            <input type="email"
                                id="email-input"
                                name="email"
                                value="{{ $invitation->email }}"
                                class="field-input readonly"
                                readonly>
                        @else
                            <input type="email"
                                id="email-input"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="admin@example.com"
                                class="field-input"
                                autocomplete="email"
                                required>
                        @endif
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
                            placeholder="Minimal 8 karakter"
                            class="field-input"
                            autocomplete="new-password"
                            required>
                        <i class="ti ti-lock input-icon"></i>
                    </div>
                    @error('password')
                        <p class="field-error"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="password-confirm-input">Konfirmasi Kata Sandi</label>
                    <div class="field-input-wrapper">
                        <input type="password"
                            id="password-confirm-input"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            class="field-input"
                            autocomplete="new-password"
                            required>
                        <i class="ti ti-lock-check input-icon"></i>
                    </div>
                </div>

                @error('token')
                    <p class="field-error" style="margin-bottom: 1rem;"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                @enderror

                <button type="submit" class="btn-submit">
                    <span>
                        <i class="ti ti-user-plus"></i>
                        Daftar sebagai {{ ucfirst($invitation->role ?? 'Admin') }}
                    </span>
                </button>
            </form>

            <p class="login-link">
                Sudah punya akun?
                <a href="/login">Login di sini</a>
            </p>
        @endif
    </div>

</body>
</html>
