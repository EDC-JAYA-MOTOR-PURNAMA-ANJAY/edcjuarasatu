<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat Sahabat AI - {{ $user->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #667eea; }
        .logo { font-size: 28px; font-weight: bold; color: #667eea; margin-bottom: 10px; }
        .title { font-size: 20px; font-weight: 600; color: #1a202c; margin-bottom: 5px; }
        .subtitle { font-size: 12px; color: #666; }
        .info-box { background: #f7fafc; border-left: 4px solid #667eea; padding: 15px; margin-bottom: 25px; }
        .info-box table { width: 100%; font-size: 11px; }
        .info-box td { padding: 4px 0; }
        .info-box td:first-child { width: 120px; font-weight: 600; color: #4a5568; }
        .conversation { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; }
        .message-header { margin-bottom: 8px; font-size: 11px; }
        .role { font-weight: 600; padding: 4px 10px; border-radius: 12px; margin-right: 10px; font-size: 10px; }
        .role-user { background: #e3f2fd; color: #1976d2; }
        .role-ai { background: #f3e5f5; color: #7b1fa2; }
        .timestamp { color: #999; font-size: 10px; }
        .message-content { font-size: 11px; color: #2d3748; padding: 10px 15px; background: #ffffff; border-left: 3px solid #e2e8f0; margin-left: 10px; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 2px solid #e2e8f0; text-align: center; font-size: 10px; color: #718096; }
        h2 { color: #1a202c; font-size: 16px; margin-bottom: 15px; border-bottom: 2px solid #667eea; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">🤖 Educounsel</div>
        <div class="title">Riwayat Chat Sahabat AI</div>
        <div class="subtitle">Export Percakapan</div>
    </div>
    <div class="info-box">
        <table>
            <tr><td>Nama Siswa</td><td>: {{ $user->nama }}</td></tr>
            <tr><td>Email</td><td>: {{ $user->email }}</td></tr>
            @if($user->kelas)<tr><td>Kelas</td><td>: {{ $user->kelas->nama_kelas }}</td></tr>@endif
            <tr><td>Total Pesan</td><td>: {{ $total_messages }} pesan</td></tr>
            <tr><td>Tanggal Export</td><td>: {{ $exported_at }}</td></tr>
        </table>
    </div>
    <h2>📝 Percakapan</h2>
    @foreach($conversations as $conv)
        <div class="conversation">
            <div class="message-header">
                <span class="role role-{{ $conv->role }}">{{ $conv->role == 'user' ? '👤 Anda' : '🤖 Sahabat AI' }}</span>
                <span class="timestamp">{{ $conv->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="message-content">{{ $conv->message }}</div>
        </div>
    @endforeach
    <div class="footer">
        <p><strong>Educounsel - Sistem Bimbingan Konseling</strong></p>
        <p>© {{ date('Y') }} Educounsel. All rights reserved.</p>
    </div>
</body>
</html>
