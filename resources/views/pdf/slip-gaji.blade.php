<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
            font-size: 13px;
            line-height: 1.5;
            padding: 30px 40px;
        }

        /* Header */
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }
        .subtitle {
            color: #6b7280;
            font-size: 13px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }
        .info-table .label {
            font-weight: bold;
            background: #f9fafb;
            width: 35%;
            color: #374151;
        }
        .info-table .value {
            width: 65%;
        }
        .info-table .total-row {
            background: #eff6ff;
        }
        .info-table .total-row td {
            font-weight: bold;
            font-size: 15px;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        /* Bukti Transfer Section */
        .bukti-section {
            margin-top: 28px;
            page-break-inside: avoid;
        }
        .bukti-title {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
        }
        .bukti-container {
            text-align: center;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #fafafa;
        }
        .bukti-img {
            max-width: 380px;
            max-height: 480px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            font-size: 11px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="title">SLIP GAJI</div>
        <div class="subtitle">
            Periode {{ \Carbon\Carbon::create($penggajian->tahun, $penggajian->bulan, 1)->translatedFormat('F Y') }}
        </div>
    </div>

    {{-- Detail Gaji --}}
    <table class="info-table">
        <tr>
            <td class="label">Nama Karyawan</td>
            <td class="value">{{ $karyawan?->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="value">{{ $karyawan?->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Properti</td>
            <td class="value">{{ $karyawan?->properti?->nama_properti ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="value">{{ $penggajian->status }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Dibayar</td>
            <td class="value">
                {{ $penggajian->tanggal_dibayar ? \Carbon\Carbon::parse($penggajian->tanggal_dibayar)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
        <tr class="total-row">
            <td class="label">Nominal Gaji</td>
            <td class="value">Rp {{ number_format($penggajian->nominal_gaji, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Bukti Transfer --}}
    @if($penggajian->bukti_transfer)
        @php
            $buktiPath = null;
            if (\Illuminate\Support\Facades\Storage::disk('local')->exists($penggajian->bukti_transfer)) {
                $buktiPath = storage_path('app/private/' . $penggajian->bukti_transfer);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($penggajian->bukti_transfer)) {
                $buktiPath = storage_path('app/public/' . $penggajian->bukti_transfer);
            }

            $buktiBase64 = null;
            if ($buktiPath && file_exists($buktiPath)) {
                $type = pathinfo($buktiPath, PATHINFO_EXTENSION);
                try {
                    $data = file_get_contents($buktiPath);
                    $buktiBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                } catch (\Exception $e) {
                    // Fail silently jika berkas tidak bisa dibaca
                }
            }
        @endphp

        @if($buktiBase64)
            <div class="bukti-section">
                <div class="bukti-title">Bukti Pembayaran</div>
                <div class="bukti-container">
                    <img class="bukti-img" src="{{ $buktiBase64 }}" alt="Bukti Transfer">
                </div>
            </div>
        @endif
    @endif

    {{-- Footer --}}
    <div class="footer">
        Dokumen ini dibuat secara otomatis oleh sistem. Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}.
    </div>

</body>
</html>
