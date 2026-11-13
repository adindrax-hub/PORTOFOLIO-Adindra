<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $profile->full_name }} — {{ $profile->headline }}</title>
<meta name="description" content="{{ $profile->bio }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:title" content="{{ $profile->full_name }}"><meta property="og:type" content="website">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/portfolio.css') }}?v={{ filemtime(public_path('css/portfolio.css')) }}">
</head>
<body>
@php
 $nav=['home'=>'Home','about'=>'About','skills'=>'Skills','projects'=>'Projects','journey'=>'Experience'];
 $hasCert=$profile->certificates->count()||$profile->achievements->count();
 if($hasCert)$nav['certificates']='Certificates';
 $nav['contact']='Contact';
@endphp
<a class="skip" href="#main">Lewati ke konten</a>
<div class="load" id="load" aria-hidden="true"><span>{{ $first }}<span style="color:var(--ac)">.</span></span><i></i></div>
<canvas id="bgc" aria-hidden="true"></canvas><div class="prog" id="prog"></div>
<header><div class="wrap"><nav aria-label="Navigasi utama">
<a class="logo" href="#home">{{ $first }}<span>.</span></a>
<div class="links" id="links">@foreach($nav as $id=>$label)<a href="#{{ $id }}">{{ $label }}</a>@endforeach</div>
<button class="tg" id="tg" type="button" aria-label="Ganti tema">Tema</button>
</nav></div></header>

<main class="wrap" id="main">
<section class="hero" id="home"><div>
<p class="meta">Welcome to my portfolio</p>
<h1>Hi, I’m <span class="grad" id="name">{{ $profile->full_name }}</span></h1>
<p><strong id="role">{{ $profile->headline }}</strong></p>
<p class="lead">{{ $profile->bio }}</p>
<div class="btns">
<a class="btn p" href="{{ $cv }}" download>@include('partials.icon',['n'=>'download','s'=>18]) Download CV</a>
@foreach(['github'=>'GitHub','linkedin'=>'LinkedIn'] as $type=>$label)@isset($c[$type])<a class="btn" href="{{ $c[$type]->url }}" target="_blank" rel="noopener">@include('partials.icon',['n'=>$type,'s'=>18]) {{ $label }}</a>@endisset @endforeach
<a class="btn" href="#contact">@include('partials.icon',['n'=>'mail','s'=>18]) Contact Me</a>
</div></div>
<aside class="lan" aria-hidden="true"><canvas id="lc"></canvas></aside>
<a class="down" href="#about" aria-label="Ke bagian About">@include('partials.icon',['n'=>'arrow','s'=>20])</a>
</section>

<section id="about"><p class="meta eb">Get to know me</p><h2>About Me</h2>
<p class="sub">Sedikit cerita tentang latar belakang dan minat saya di dunia teknologi.</p>
<div class="two"><div><p>{{ $profile->about }}</p>
@foreach($profile->educations as $e)<div class="card ec"><span class="ibox">@include('partials.icon',['n'=>'grad','s'=>20])</span><div><strong>{{ $e->institution }}</strong><br><small class="meta">{{ $e->degree }} · {{ $e->period }}</small></div></div>@endforeach
@if($profile->location)<div class="card ec"><span class="ibox alt">@include('partials.icon',['n'=>'pin','s'=>20])</span><div><strong>Lokasi</strong><br><small class="meta">{{ $profile->location }}</small></div></div>@endif
</div>
<div><h3>Interests</h3><div class="ints" id="interests">@foreach($profile->interests as $in)<div class="int">@include('partials.icon',['n'=>$in->icon,'s'=>20]) <span>{{ $in->name }}</span></div>@endforeach</div></div></div></section>

<section id="skills"><p class="meta eb">What I work with</p><h2>Skills &amp; Technologies</h2>
<p class="sub">Kumpulan bahasa, framework, tools, dan bidang yang saya pelajari dan gunakan.</p>
<div class="filters" id="filters"><button type="button" aria-pressed="true" data-c="All">All</button>@foreach($profile->skillCategories as $k)<button type="button" aria-pressed="false" data-c="{{ $k->name }}">{{ $k->name }}</button>@endforeach</div>
<div class="skills" id="skillList">@foreach($profile->skillCategories as $k)@foreach($k->skills as $s)<div class="skill" data-c="{{ $k->name }}"><span class="ibox">@include('partials.icon',['n'=>'code','s'=>20])</span><strong>{{ $s->name }}</strong><small>{{ $k->name }}</small></div>@endforeach @endforeach</div></section>

<section id="projects"><p class="meta eb">Selected work</p><h2>Projects</h2>
<p class="sub">Beberapa project yang telah saya kembangkan, mulai dari aplikasi web, IoT, hingga kecerdasan buatan.</p>
<div class="grid">@foreach($profile->projects as $pr)<article class="card">@if($pr->image_path && file_exists(public_path($pr->image_path)))<img class="pimg" src="{{ asset($pr->image_path) }}" alt="Tampilan {{ $pr->title }}" loading="lazy">@else<div class="thumb" aria-hidden="true">{{ $pr->icon }}</div>@endif<p class="meta" style="margin:0">{{ $pr->category }}</p><h3>{{ $pr->title }}</h3><p>{{ $pr->description }}</p><div>@foreach($pr->technologies as $tc)<span class="tag">{{ $tc->name }}</span>@endforeach</div><a href="#project-{{ $pr->slug }}">Lihat detail</a>@if($pr->url)<a href="{{ $pr->url }}" target="_blank" rel="noopener" style="margin-left:16px">Buka ↗</a>@endif</article>@endforeach</div></section>

<section id="journey"><p class="meta eb">My path so far</p><h2>Journey Timeline</h2>
<p class="sub">Perjalanan pendidikan, pengalaman kerja, dan organisasi yang membentuk kemampuan saya saat ini.</p>
<div class="tl" id="tl">@foreach($timeline as $t)<article class="item"><span class="ico">@include('partials.icon',['n'=>$t['icon'],'s'=>20])</span><span class="meta pd">{{ $t['period'] }}</span><h3>{{ $t['title'] }}</h3><strong class="org">{{ $t['org'] }}</strong>@if($t['desc'])<p>{{ $t['desc'] }}</p>@endif<div class="tags">@foreach($t['tags'] as $g)<span class="tag">{{ $g }}</span>@endforeach</div></article>@endforeach</div></section>

@if($hasCert)<section id="certificates"><p class="meta eb">Proof of learning</p><h2>Certificates &amp; Achievements</h2>
<p class="sub">Sertifikat pembelajaran dan pencapaian yang telah saya raih.</p>
<div class="grid">@foreach($profile->certificates as $i=>$cert)<div class="card cert" data-cert="{{ $i }}" tabindex="0" role="button" style="cursor:pointer">@if($cert->image_path)<img src="{{ asset($cert->image_path) }}" alt="Sertifikat {{ $cert->title }}" loading="lazy">@endif<span class="meta">{{ $cert->year }}</span><h3>{{ $cert->title }}</h3><p class="meta" style="margin:0">{{ $cert->issuer }}</p></div>@endforeach
@foreach($profile->achievements as $a)<div class="card"><span class="ibox">@include('partials.icon',['n'=>'trophy','s'=>20])</span><p class="meta" style="margin:12px 0 0">{{ $a->year }}</p><h3>{{ $a->title }}</h3><p>{{ $a->description }}</p></div>@endforeach</div></section>@endif

<section id="contact"><p class="meta eb">Let’s connect</p><h2>Contact Me</h2>
<p class="sub">Punya project, pertanyaan, atau ingin berkolaborasi? Jangan ragu untuk menghubungi saya.</p>
<div class="two rev"><div>@foreach($profile->contacts as $ct)<a class="card ec" href="{{ $ct->url }}" target="_blank" rel="noopener"><span class="ibox">@include('partials.icon',['n'=>$ct->type,'s'=>20])</span><div><small class="meta">{{ $ct->label }}</small><br><strong>{{ $ct->value }}</strong></div></a>@endforeach</div>
<form id="form" class="card"><div class="row2"><div><label for="n">Name</label><input id="n" required maxlength="100" placeholder="Nama lengkap kamu" autocomplete="name"><small class="err" data-for="name"></small></div><div><label for="e">Email</label><input id="e" type="email" required maxlength="150" placeholder="email@contoh.com" autocomplete="email"><small class="err" data-for="email"></small></div></div>
<div><label for="m">Message</label><textarea id="m" rows="5" required maxlength="3000" placeholder="Ceritakan tentang project atau pesanmu..."></textarea><small class="err" data-for="message"></small></div>
<div class="hp" aria-hidden="true"><label>Website<input id="website" name="website" tabindex="-1" autocomplete="off"></label></div>
<button class="btn p" type="submit">@include('partials.icon',['n'=>'send','s'=>18]) Send Message</button><p class="meta" id="fs" role="status"></p></form></div></section>
</main>
<footer><div class="wrap">© {{ date('Y') }} {{ $profile->full_name }}. All rights reserved.</div></footer>
<script>window.__D = {{ Js::from($js) }};</script>
<script src="{{ asset('js/portfolio.js') }}?v={{ filemtime(public_path('js/portfolio.js')) }}"></script>
</body>
</html>
