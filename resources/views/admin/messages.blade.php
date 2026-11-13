<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex">
<title>Inbox portofolio</title>
<style>
body{margin:0;background:#0c0a0b;color:#f3ede6;font:16px/1.6 system-ui,sans-serif}
main{max-width:860px;margin:0 auto;padding:32px 20px}
h1{margin:0 0 4px}p.s{color:#a69b94;margin:0 0 24px}
.m{border:1px solid #2b2326;border-left:4px solid #2b2326;border-radius:6px;background:#151112;padding:16px 18px;margin-bottom:14px}
.m.new{border-left-color:#ff5a5f}
.m h3{margin:0;font-size:1.05rem}.m small{color:#a69b94}.m p{white-space:pre-wrap;margin:10px 0 14px}
.row{display:flex;flex-wrap:wrap;gap:8px}
a,button{font:inherit;font-size:.85rem;padding:6px 12px;border:1px solid #3a2f33;border-radius:4px;background:none;color:#f3ede6;text-decoration:none;cursor:pointer}
a:hover,button:hover{border-color:#ff5a5f}.del{color:#ff7b7f}
</style></head><body><main>
<h1>Inbox portofolio</h1>
<p class="s">{{ $messages->count() }} pesan · {{ $messages->where('is_read',false)->count() }} belum dibaca · <a href="/">Lihat web</a></p>
@forelse($messages as $m)
<article class="m {{ $m->is_read ? '' : 'new' }}">
<h3>{{ $m->name }} <small>&lt;{{ $m->email }}&gt; · {{ $m->created_at->format('d M Y H:i') }}</small></h3>
<p>{{ $m->body }}</p>
<div class="row">
<a href="mailto:{{ $m->email }}?subject={{ rawurlencode('Re: pesan di portofolio') }}">Balas lewat email</a>
@unless($m->is_read)<form method="POST" action="/admin/messages/{{ $m->id }}/read">@csrf<button>Tandai dibaca</button></form>@endunless
<form method="POST" action="/admin/messages/{{ $m->id }}" onsubmit="return confirm('Hapus pesan ini?')">@csrf @method('DELETE')<button class="del">Hapus</button></form>
</div></article>
@empty<p>Belum ada pesan masuk.</p>@endforelse
</main></body></html>
