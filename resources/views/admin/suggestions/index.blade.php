<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Suggestions</title>
    <style>
        body{font-family:Arial, sans-serif; padding:20px}
        .card{border:1px solid #ddd; border-radius:10px; padding:14px; margin-bottom:12px}
        .meta{color:#666; font-size:13px}
        form{display:inline}
        button{cursor:pointer}
    </style>
</head>
<body>
    <h2>Suggestions</h2>

    @if(session('success'))
        <div style="padding:10px;border:1px solid #8bc34a;background:#f1fff0;margin:10px 0;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    @foreach($suggestions as $s)
        <div class="card">
            <div class="meta">
                <b>{{ $s->name ?? 'Anonymous' }}</b>
                @if($s->email) — {{ $s->email }} @endif
                <br>
                IP: {{ $s->ip_address ?? '-' }} • {{ $s->created_at->format('d M Y H:i') }}
            </div>
            <p style="white-space:pre-wrap;margin-top:10px;">{{ $s->message }}</p>

            <form action="{{ route('admin.suggestions.destroy', $s->id) }}" method="POST"
                  onsubmit="return confirm('Hapus suggestion ini?')">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </div>
    @endforeach

    {{ $suggestions->links() }}
</body>
</html>