<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
</head>
<body>
    <h2>Slip Gaji</h2>
    <p>Halo {{ $penggajian->karyawan?->nama ?? '-' }},</p>
    <p>Berikut slip gaji Anda untuk periode {{ \\Carbon\\Carbon::create()->month($penggajian->bulan)->translatedFormat('F') }} {{ $penggajian->tahun }}.</p>
    <p>Nominal gaji: Rp {{ number_format($penggajian->nominal_gaji, 0, ',', '.') }}</p>
    <p>Terima kasih.</p>
</body>
</html>
