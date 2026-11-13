(()=>{'use strict';
const D=window.__D||{},$=id=>document.getElementById(id),$$=(s,r=document)=>Array.from(r.querySelectorAll(s));
const root=document.documentElement,rm=matchMedia('(prefers-reduced-motion:reduce)').matches,fine=matchMedia('(pointer:fine)').matches;
const esc=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
root.classList.add('js');

/* tema */
try{const t=localStorage.getItem('theme');if(t)root.dataset.theme=t}catch(e){}
$('tg').addEventListener('click',()=>{const n=root.dataset.theme==='dark'?'light':'dark';root.dataset.theme=n;try{localStorage.setItem('theme',n)}catch(e){}dispatchEvent(new Event('themechange'))});

/* loader */
const hideLoad=()=>{const l=$('load');if(l)l.classList.add('done');root.classList.add('ready')};
addEventListener('load',()=>setTimeout(hideLoad,rm?0:700));setTimeout(hideLoad,2600);

/* pecah teks hero per huruf */
function split(el){let n=0;(function walk(node){Array.from(node.childNodes).forEach(c=>{
 if(c.nodeType===3){const f=document.createDocumentFragment();c.textContent.split(/(\s+)/).forEach(tok=>{if(!tok)return;
  if(/^\s+$/.test(tok)){f.append(tok);return}
  const wd=document.createElement('span');wd.className='w';wd.setAttribute('aria-hidden','true');
  Array.from(tok).forEach(ch=>{const s=document.createElement('span');s.className='ch';s.style.setProperty('--c',n++);s.textContent=ch;wd.append(s)});f.append(wd)});c.replaceWith(f)}
 else if(c.nodeType===1)walk(c)})})(el)}
if(!rm)$$('.split').forEach(split);

/* teks peran mengetik */
const roleEl=$('role');
if(roleEl&&!rm){const R=[D.role].concat(D.taglines||[]);let r=0,c=R[0].length,del=true;
 setTimeout(function t(){const wd=R[r];c+=del?-1:1;roleEl.textContent=wd.slice(0,c);let ms=del?30:65;
  if(!del&&c===wd.length){del=true;ms=1800}else if(del&&c===0){del=false;r=(r+1)%R.length;ms=320}setTimeout(t,ms)},2600);
 }

/* muncul saat scroll */
const io=new IntersectionObserver(es=>es.forEach(e=>{if(!e.isIntersecting)return;const t=e.target;io.unobserve(t);t.classList.add('in');
 if(t.classList.contains('rv'))setTimeout(()=>t.classList.remove('rv','in'),1800)}),{threshold:.12});
$$('section:not(.hero) h2,section:not(.hero) .sub,section:not(.hero) .card,.item,.filters,#skillList,#form,#interests').forEach(el=>el.classList.add('rv'));
$$('.rv').forEach(el=>{const k=Array.from(el.parentElement.children).indexOf(el);el.style.setProperty('--d',Math.min(k,6)*90+'ms');io.observe(el)});

/* menu aktif, progress scroll, garis timeline */
const links=$$('#links a'),so=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting)links.forEach(a=>a.toggleAttribute('aria-current',a.getAttribute('href')==='#'+e.target.id))}),{rootMargin:'-45% 0px -50% 0px'});
$$('main section[id]').forEach(s=>so.observe(s));
const prog=$('prog'),tl=$('tl');
const onScroll=()=>{const h=root.scrollHeight-innerHeight;prog.style.transform='scaleX('+(h>0?scrollY/h:0)+')';
 if(tl){const r=tl.getBoundingClientRect();tl.style.setProperty('--p',Math.max(0,Math.min(1,(innerHeight*.6-r.top)/r.height)))}};
addEventListener('scroll',onScroll,{passive:true});onScroll();

/* angka naik */
const cio=new IntersectionObserver(es=>es.forEach(e=>{if(!e.isIntersecting)return;cio.unobserve(e.target);const el=e.target,end=+el.dataset.count;
 if(rm){el.textContent=end;return}const t0=performance.now();
 (function f(t){const k=Math.min(1,(t-t0)/1300);el.textContent=Math.round(end*(1-Math.pow(1-k,3)));if(k<1)requestAnimationFrame(f)})(t0)}),{threshold:.6});
$$('[data-count]').forEach(el=>{if(!rm)el.textContent='0';cio.observe(el)});

/* filter skill */
$('filters').addEventListener('click',e=>{const b=e.target.closest('button');if(!b)return;
 $$('#filters button').forEach(x=>x.setAttribute('aria-pressed',String(x===b)));let i=0;
 $$('.skill').forEach(s=>{const on=b.dataset.c==='All'||s.dataset.c===b.dataset.c;s.hidden=!on;if(on)s.style.setProperty('--i',i++)})});
$$('.skill').forEach((s,i)=>s.style.setProperty('--i',i));

/* tilt kartu, tombol magnetik, kursor */
if(fine&&!rm){
 $$('#projects .card,#certificates .card').forEach(c=>{c.addEventListener('pointermove',e=>{const r=c.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;
  c.style.transform='perspective(900px) rotateX('+(-y*6).toFixed(2)+'deg) rotateY('+(x*8).toFixed(2)+'deg) translateY(-4px)'});c.addEventListener('pointerleave',()=>{c.style.transform=''})});
 $$('.btns .btn,#form button[type=submit]').forEach(b=>{b.addEventListener('pointermove',e=>{const r=b.getBoundingClientRect();
  b.style.transform='translate('+((e.clientX-r.left-r.width/2)*.2).toFixed(1)+'px,'+((e.clientY-r.top-r.height/2)*.3).toFixed(1)+'px)'});b.addEventListener('pointerleave',()=>{b.style.transform=''})});
 const c=document.createElement('div');c.className='cur';document.body.append(c);let x=0,y=0,tx=0,ty=0,on=false;
 addEventListener('pointermove',e=>{tx=e.clientX;ty=e.clientY;if(!on){on=true;c.classList.add('on');x=tx;y=ty}c.classList.toggle('big',!!e.target.closest('a,button,.card,canvas'))});
 document.addEventListener('pointerleave',()=>{on=false;c.classList.remove('on')});
 (function f(){x+=(tx-x)*.2;y+=(ty-y)*.2;c.style.transform='translate('+x+'px,'+y+'px)';requestAnimationFrame(f)})();
}

/* jendela detail project dan sertifikat */
const dlg=document.createElement('dialog');document.body.append(dlg);
const show=(html,k)=>{dlg.dataset.k=k;dlg.innerHTML='<button class="x" type="button" aria-label="Tutup">×</button><div class="dlg-in">'+html+'</div>';if(!dlg.open)dlg.showModal()};
dlg.addEventListener('click',e=>{if(e.target===dlg||e.target.closest('.x'))dlg.close()});
dlg.addEventListener('close',()=>{if(/^#project-/.test(location.hash))history.replaceState(null,'','#projects')});
const media=(img,emoji,h)=>img?'<img class="pimg" src="'+esc(img)+'" alt="">':'<div class="thumb" aria-hidden="true"'+(h?' style="height:'+h+'px"':'')+'>'+esc(emoji)+'</div>';
function showProject(p){show('<span class="no mono">'+esc(p.c)+'</span><h3 style="font-size:1.6rem">'+esc(p.t)+'</h3>'+media(p.img,p.i)+'<p>'+esc(p.d)+'</p><div>'+(p.s||[]).map(x=>'<span class="tag">'+esc(x)+'</span>').join('')+'</div>'+(p.u&&p.u!=='#'?'<a class="btn" href="'+esc(p.u)+'" target="_blank" rel="noopener">Buka project</a>':''),'p')}
function showCert(i){const c=(D.certs||[])[i];if(!c)return;show('<span class="no mono">'+esc(c[2])+'</span><h3 style="font-size:1.5rem">'+esc(c[0])+'</h3>'+media(c[3],'🏅',180)+'<p>Diterbitkan oleh <strong>'+esc(c[1])+'</strong>.</p>','c')}
document.addEventListener('click',e=>{const c=e.target.closest('[data-cert]');if(c)showCert(+c.dataset.cert)});
document.addEventListener('keydown',e=>{if((e.key==='Enter'||e.key===' ')&&e.target.matches&&e.target.matches('[data-cert]')){e.preventDefault();showCert(+e.target.dataset.cert)}});
function route(){const m=location.hash.match(/^#project-([a-z0-9-]+)$/),p=m&&(D.projects||[]).find(x=>x.slug===m[1]);
 if(p)showProject(p);else if(dlg.open&&dlg.dataset.k==='p')dlg.close()}
addEventListener('hashchange',route);route();

/* form kontak */
const form=$('form');
if(form){const st=$('fs'),errs=$$('.err',form),btn=form.querySelector('button[type=submit]');
 const say=(t,c)=>{st.textContent=t;st.className=c||''};
 form.addEventListener('submit',async e=>{e.preventDefault();errs.forEach(x=>x.textContent='');say('Mengirim…');btn.disabled=true;
  try{const r=await fetch('/contact',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
   body:JSON.stringify({name:$('n').value,email:$('e').value,message:$('m').value,website:$('website').value})});
   const j=await r.json().catch(()=>({}));
   if(r.status===422){const er=j.errors||{};errs.forEach(x=>{x.textContent=(er[x.dataset.for]||[''])[0]});say('Periksa kembali isian yang ditandai.','bad')}
   else if(r.status===429)say('Terlalu banyak percobaan. Coba lagi beberapa menit lagi.','bad')
   else if(r.status===419)say('Sesi habis. Muat ulang halaman lalu kirim lagi.','bad')
   else if(!r.ok)throw new Error(r.status);
   else{form.reset();say('Terima kasih! Pesanmu sudah terkirim dan akan segera saya baca.','ok')}
  }catch(err){say('Pesan belum terkirim. Periksa koneksi lalu coba lagi.','bad')}
  btn.disabled=false})}

/* background: Topology flow field (versi native dari Vanta Topology, tanpa p5 dan tanpa CDN) */
(function(){const cv=$('bgc');if(!cv)return;
 const ctx=cv.getContext('2d'),CELL=10,PAD=200,SEED=0,col={};
 let W,H,dpr,cols,rows,fx,fy,N,x,y,vx,vy,ax,ay,g,timer=0;
 const hash=(a,b)=>{const s=Math.sin(a*127.1+b*311.7+SEED)*43758.5453;return s-Math.floor(s)};
 const vn=(a,b)=>{const xi=Math.floor(a),yi=Math.floor(b),xf=a-xi,yf=b-yi,u=xf*xf*(3-2*xf),v=yf*yf*(3-2*yf),p=hash(xi,yi),q=hash(xi+1,yi),r=hash(xi,yi+1),s=hash(xi+1,yi+1);return p+(q-p)*u+(r-p)*v+(p-q-r+s)*u*v};
 const noise=(a,b)=>{let t=0,amp=.5,f=1;for(let o=0;o<4;o++){t+=amp*vn(a*f,b*f);amp*=.5;f*=2}return t};
 const rgba=(hex,a)=>{const m=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);return m?'rgba('+parseInt(m[1],16)+','+parseInt(m[2],16)+','+parseInt(m[3],16)+','+a+')':'rgba(108,99,255,'+a+')'};
 const colors=()=>{const s=getComputedStyle(root),light=root.dataset.theme==='light',a=light?.08:.06;col.a=rgba(s.getPropertyValue('--ac').trim(),a);col.b=rgba(s.getPropertyValue('--ac2').trim(),a)};
 function buildField(){cols=Math.floor((W+PAD)/CELL);rows=Math.floor((H+PAD)/CELL);fx=new Float32Array(cols*rows);fy=new Float32Array(cols*rows);
  const S=32,cs=[],sn=[];for(let a=0;a<S;a++){cs.push(Math.cos(a/S*6.2832)*.1);sn.push(Math.sin(a/S*6.2832)*.1)}
  for(let r=0;r<rows;r++)for(let c=0;c<cols;c++){let mx=0,my=0,nx=0,ny=0,hi=-1,lo=2;
   for(let a=0;a<S;a++){const px=c*.003+cs[a],py=r*.003+sn[a],n=noise(px,py);if(n>hi){hi=n;mx=px;my=py}if(n<lo){lo=n;nx=px;ny=py}}
   const dx=nx-mx,dy=ny-my,k=(hi-lo)/(Math.hypot(dx,dy)||1);fx[r*cols+c]=dx*k;fy[r*cols+c]=dy*k}}
 function spawn(){N=Math.max(1200,Math.min(6500,Math.round(4500*W*H/(1920*1080))));
  x=new Float32Array(N);y=new Float32Array(N);vx=new Float32Array(N);vy=new Float32Array(N);ax=new Float32Array(N);ay=new Float32Array(N);g=new Uint8Array(N);
  for(let i=0;i<N;i++){x[i]=Math.random()*(W+PAD);y[i]=Math.random()*(H+PAD);g[i]=Math.random()<.2?1:0}}
 function step(){const Wp=W+PAD,Hp=H+PAD,half=PAD/2,paths=[new Path2D(),new Path2D()];
  ctx.globalCompositeOperation='destination-out';ctx.fillStyle='rgba(0,0,0,.012)';ctx.fillRect(0,0,W,H);ctx.globalCompositeOperation='source-over';
  for(let i=0;i<N;i++){const px=x[i],py=y[i],cx=Math.min(cols-1,Math.max(0,(px/CELL)|0)),cy=Math.min(rows-1,Math.max(0,(py/CELL)|0)),k=cy*cols+cx;
   let nx=px+vx[i],ny=py+vy[i];nx=((nx%Wp)+Wp)%Wp;ny=((ny%Hp)+Hp)%Hp;
   let tx=vx[i]+ax[i],ty=vy[i]+ay[i];const m=Math.hypot(tx,ty);if(m>0){tx=tx/m*2.2;ty=ty/m*2.2}
   vx[i]=tx;vy[i]=ty;ax[i]=fx[k]*3;ay[i]=fy[k]*3;
   if(Math.hypot(nx-px,ny-py)<10){const p=paths[g[i]];p.moveTo(px-half,py-half);p.lineTo(nx-half,ny-half)}
   x[i]=nx;y[i]=ny}
  ctx.lineWidth=1;ctx.strokeStyle=col.a;ctx.stroke(paths[0]);ctx.strokeStyle=col.b;ctx.stroke(paths[1])}
 function start(){dpr=Math.min(devicePixelRatio||1,1.5);W=innerWidth;H=innerHeight;cv.width=W*dpr;cv.height=H*dpr;ctx.setTransform(dpr,0,0,dpr,0,0);
  colors();buildField();spawn();ctx.clearRect(0,0,W,H);for(let f=0;f<(rm?260:140);f++)step()}
 function loop(){requestAnimationFrame(loop);if(!document.hidden)step()}
 addEventListener('resize',()=>{clearTimeout(timer);timer=setTimeout(start,250)});
 addEventListener('themechange',start);
 start();if(!rm)requestAnimationFrame(loop)})();

/* lanyard: tali dan kartu foto dengan fisika verlet, bisa ditarik */
(function(){const cv=$('lc');if(!cv)return;
 const ctx=cv.getContext('2d'),N=6,W=210,H=300,css={},tt={x:0,y:0,tx:0,ty:0};
 let w,h,dpr,P=[],B,seg,drag=null,vis=true,fr=0;
 const ph=new Image();if(D.photo){ph.src=D.photo;ph.onload=()=>{if(P.length)draw()}}
 const parts=(D.name||'').split(' '),first=parts[0]||'',rest=parts.slice(1).join(' '),initials=parts.map(x=>x[0]).slice(0,2).join('').toUpperCase();
 const col=()=>{const s=getComputedStyle(root);['ac','ac2','surf','line'].forEach(k=>css[k]=s.getPropertyValue('--'+k).trim())};
 function init(){dpr=Math.min(devicePixelRatio||1,2);w=cv.clientWidth;h=cv.clientHeight;if(!w||!h)return;cv.width=w*dpr;cv.height=h*dpr;
  seg=Math.max(10,Math.min(26,(h-H-40)/N));P=[];for(let i=0;i<=N;i++){const y=-20+i*seg;P.push({x:w/2,y:y,px:w/2,py:y})}
  const l=P[N];B={x:l.x,y:l.y+H,px:l.x+(rm?0:8),py:l.y+H};col();draw()}
 const pt=p=>{const vx=(p.x-p.px)*.995,vy=(p.y-p.py)*.995;p.px=p.x;p.py=p.y;p.x+=vx;p.y+=vy+.55};
 function link(a,b,d,wa,wb){const dx=b.x-a.x,dy=b.y-a.y,l=Math.hypot(dx,dy)||1,k=(l-d)/l,s=wa+wb;a.x+=dx*k*wa/s;a.y+=dy*k*wa/s;b.x-=dx*k*wb/s;b.y-=dy*k*wb/s}
 function step(){P.slice(1).concat(B).forEach(pt);
  if(drag){const cx=(P[N].x+B.x)/2,cy=(P[N].y+B.y)/2,dx=drag.x-drag.ox-cx,dy=drag.y-drag.oy-cy;[P[N],B].forEach(p=>{p.x+=dx*.3;p.y+=dy*.3})}
  for(let k=0;k<10;k++){P[0].x=w/2;P[0].y=-20;for(let i=0;i<N;i++)link(P[i],P[i+1],seg,i?1:0,1);link(P[N],B,H,1,1);
   [P[N],B].forEach(p=>{p.x=Math.max(10,Math.min(w-10,p.x))});B.y=Math.min(h-10,B.y)}}
 function draw(){ctx.setTransform(dpr,0,0,dpr,0,0);ctx.clearRect(0,0,w,h);tt.x+=(tt.tx-tt.x)*.12;tt.y+=(tt.ty-tt.y)*.12;
  const a=P[N],ang=Math.atan2(B.y-a.y,B.x-a.x)-Math.PI/2,cx=(a.x+B.x)/2,cy=(a.y+B.y)/2;
  ctx.lineCap='butt';ctx.lineJoin='round';ctx.beginPath();ctx.moveTo(P[0].x,P[0].y);
  for(let i=1;i<N;i++)ctx.quadraticCurveTo(P[i].x,P[i].y,(P[i].x+P[i+1].x)/2,(P[i].y+P[i+1].y)/2);
  ctx.lineTo(a.x,a.y);ctx.strokeStyle=css.ac;ctx.lineWidth=15;ctx.stroke();
  ctx.strokeStyle='rgba(0,0,0,.28)';ctx.lineWidth=1.5;ctx.setLineDash([5,7]);ctx.stroke();ctx.setLineDash([]);
  ctx.save();ctx.translate(cx,cy);ctx.rotate(ang);ctx.transform(1-.1*Math.abs(tt.x),.07*tt.x,.06*tt.y,1-.05*Math.abs(tt.y),0,0);
  const rr=()=>{ctx.beginPath();ctx.roundRect(-W/2,-H/2,W,H,12)};
  rr();ctx.shadowColor='rgba(0,0,0,.45)';ctx.shadowBlur=28;ctx.shadowOffsetY=12;ctx.fillStyle=css.surf;ctx.fill();ctx.shadowColor='transparent';
  ctx.save();rr();ctx.clip();
  if(ph.complete&&ph.naturalWidth){const s=Math.max(W/ph.naturalWidth,H/ph.naturalHeight),dw=ph.naturalWidth*s,dh=ph.naturalHeight*s;ctx.drawImage(ph,-dw/2,-dh/2,dw,dh)}
  else{ctx.fillStyle=css.ac;ctx.font='800 84px Inter,system-ui,sans-serif';ctx.textAlign='center';ctx.fillText(initials,0,20)}
  const g=ctx.createLinearGradient(0,H*.05,0,H/2);g.addColorStop(0,'rgba(5,8,22,0)');g.addColorStop(1,'rgba(5,8,22,.94)');ctx.fillStyle=g;ctx.fillRect(-W/2,H*.05,W,H*.45);
  ctx.fillStyle=css.ac;ctx.fillRect(-W/2,-H/2,W,6);ctx.textAlign='left';
  ctx.fillStyle='#fff';ctx.font='800 28px Inter,system-ui,sans-serif';ctx.fillText(first,-W/2+16,H/2-66,W-32);
  ctx.fillStyle='#f3ede6';ctx.font='600 15px Inter,system-ui,sans-serif';ctx.fillText(rest,-W/2+16,H/2-44,W-32);
  ctx.fillStyle=css.ac2;ctx.font='600 11px Inter,system-ui,sans-serif';ctx.fillText((D.role||'').toUpperCase(),-W/2+16,H/2-24,W-32);
  const gx=tt.x*W/2,gy=tt.y*H/2,gl=ctx.createRadialGradient(gx,gy,0,gx,gy,W);gl.addColorStop(0,'rgba(255,255,255,.2)');gl.addColorStop(1,'rgba(255,255,255,0)');ctx.fillStyle=gl;ctx.fillRect(-W/2,-H/2,W,H);
  ctx.restore();rr();ctx.strokeStyle='rgba(255,255,255,.14)';ctx.lineWidth=1;ctx.stroke();
  ctx.fillStyle='rgba(0,0,0,.6)';ctx.beginPath();ctx.roundRect(-16,-H/2+14,32,7,3.5);ctx.fill();
  ctx.fillStyle='#cfd3d8';ctx.beginPath();ctx.arc(0,-H/2,9,0,7);ctx.fill();ctx.fillStyle='#6b7077';ctx.beginPath();ctx.arc(0,-H/2,3.5,0,7);ctx.fill();ctx.restore()}
 const loc=e=>{const r=cv.getBoundingClientRect();return{x:e.clientX-r.left,y:e.clientY-r.top}};
 const local=p=>{const l=P[N],cx=(l.x+B.x)/2,cy=(l.y+B.y)/2,n=Math.hypot(B.x-l.x,B.y-l.y)||1,a=(B.x-l.x)/n,b=(B.y-l.y)/n,dx=p.x-cx,dy=p.y-cy;return{u:-dx*b+dy*a,v:dx*a+dy*b,dx:dx,dy:dy}};
 cv.addEventListener('pointerdown',e=>{if(rm)return;const p=loc(e),q=local(p);
  if(Math.abs(q.v)<=H/2&&Math.abs(q.u)<=W/2){drag={x:p.x,y:p.y,ox:q.dx,oy:q.dy};cv.setPointerCapture(e.pointerId);cv.style.cursor='grabbing'}});
 cv.addEventListener('pointermove',e=>{const p=loc(e);if(drag){drag.x=p.x;drag.y=p.y}const q=local(p);tt.tx=Math.max(-1,Math.min(1,q.u/(W/2)));tt.ty=Math.max(-1,Math.min(1,q.v/(H/2)))});
 cv.addEventListener('pointerleave',()=>{tt.tx=tt.ty=0});
 const end=()=>{drag=null;cv.style.cursor=''};cv.addEventListener('pointerup',end);cv.addEventListener('pointercancel',end);
 new IntersectionObserver(es=>{vis=es[0].isIntersecting}).observe(cv);new ResizeObserver(init).observe(cv);
 addEventListener('themechange',()=>{col();if(P.length)draw()});
 if(document.fonts&&document.fonts.ready)document.fonts.ready.then(()=>{if(P.length)draw()});
 if(!rm){let last=performance.now(),acc=0;(function loop(t){requestAnimationFrame(loop);if(!vis){last=t;return}
  acc+=Math.min((t-last)/1000,.05);last=t;while(acc>=1/60){step();acc-=1/60}if(++fr%20===0)col();draw()})(last)}
})();
})();
