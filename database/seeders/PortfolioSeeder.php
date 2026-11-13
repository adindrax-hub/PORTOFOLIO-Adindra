<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Profile,Technology};
class PortfolioSeeder extends Seeder{
 public function run():void{
  $p=Profile::create(['full_name'=>'Adindra Hakim Mulyawan','headline'=>'Informatics Engineering Student','location'=>'Sukabumi, Jawa Barat',
   'bio'=>'Mahasiswa Teknik Informatika Universitas Muhammadiyah Sukabumi yang berfokus pada software development dan engineering, mencakup web, aplikasi mobile, IoT, software design pattern, dan kecerdasan buatan.',
   'about'=>'Saya mahasiswa Teknik Informatika di Universitas Muhammadiyah Sukabumi (UMMI), Sukabumi, Jawa Barat. Saya suka membangun aplikasi web dan mobile, merangkai proyek elektronika dengan Arduino, serta mengeksplorasi algoritma AI dengan Python.',
   'photo_path'=>'images/profile.jpg','cv_path'=>'cv/Adindra-Hakim-Mulyawan-CV.pdf','taglines'=>['Web Developer','Mobile App Developer','AI & IoT Enthusiast']]);
  $p->contacts()->createMany([
   ['type'=>'email','label'=>'Email','value'=>'adindrax@gmail.com','url'=>'mailto:adindrax@gmail.com','sort'=>1],
   ['type'=>'github','label'=>'GitHub','value'=>'@adindrax-hub','url'=>'https://github.com/adindrax-hub','sort'=>2],
   ['type'=>'linkedin','label'=>'LinkedIn','value'=>'Adindra Hakim Mulyawan','url'=>'https://www.linkedin.com/in/adindra-hakim-mulyawan-7a2993393/','sort'=>3]]);
  $i=0;foreach([['Software Development','code'],['Web Development','code'],['Mobile Development','mobile'],['IoT & Arduino','cpu'],['Software Design Patterns','db'],['Artificial Intelligence','sparkle']] as $x)
   $p->interests()->create(['name'=>$x[0],'icon'=>$x[1],'sort'=>++$i]);
  $p->educations()->createMany([
   ['institution'=>'SMA MBS Ki Bagus Hadikusumo','degree'=>'Sekolah Menengah Atas (SMA)','period'=>'Pendidikan menengah atas'],
   ['institution'=>'Universitas Muhammadiyah Sukabumi (UMMI)','degree'=>'Teknik Informatika','period'=>'Sedang menempuh S1','description'=>'Fokus pada software development, web, mobile, IoT, dan AI.','tags'=>['Laravel','Next.js','Python','Arduino']],
  ]);
  // Isi data berikut dengan datamu (kosong = bagian otomatis tidak tampil). Contoh:
  // $p->experiences()->create(['position'=>'Intern','company'=>'Nama Perusahaan','period'=>'Jul 2025 - Sep 2025','start_year'=>2025,'description'=>'...','tags'=>['Laravel']]);
  // $p->organizations()->create(['name'=>'Nama Organisasi','position'=>'Anggota','period'=>'2024 - 2025','start_year'=>2024,'description'=>'...']);
  // $p->achievements()->create(['title'=>'Juara 1 ...','description'=>'...','year'=>'2025','sort'=>1]);
  // $p->certificates()->create(['title'=>'...','issuer'=>'...','year'=>'2026','image_path'=>'images/certificates/nama.png','sort'=>1]);
  $n=0;$j=0;
  foreach(['Programming'=>['PHP','JavaScript','TypeScript','Python','C++'],'Frontend'=>['HTML','CSS','Tailwind CSS','React','Next.js','GSAP ScrollTrigger'],'Backend'=>['Laravel','Node.js'],'Hardware'=>['Arduino'],'AI'=>['AI Algorithms'],'Tools'=>['Git','GitHub','VS Code','Arduino IDE','Google Colab']] as $cat=>$list){
   $c=$p->skillCategories()->create(['name'=>$cat,'sort'=>++$n]);
   foreach($list as $s)$c->skills()->create(['name'=>$s,'sort'=>++$j]);}
  $k=0;foreach([
   ['ROBO-LEARN','IoT & Web Application','🦾','Platform web IoT edukatif untuk siswa SMK TKJ: dashboard kontrol lengan robot 4-axis berbasis ESP32 secara real-time, editor visual Blockly, perekam gerakan makro, dan monitor telemetri. Dikerjakan berkelompok.',['Laravel','Blockly','Tailwind CSS','ESP32','MySQL'],'images/projects/robo-learn.png'],
   ['Arduino Electronics Projects','Internet of Things','🔌','Kumpulan proyek elektronika berbasis Arduino: buzzer pemutar melodi, push button, relay, dan tampilan 7-segment, diprogram dengan C++.',['Arduino','C++','Buzzer','Relay','7-Segment']],
   ['InData','Web Application','📦','Sistem manajemen data terpadu berbasis web (full-stack) dengan PHP native dan MariaDB: login berbasis session, CRUD dinamis dalam satu modal, unggah banyak berkas, tanda tangan digital di kanvas, serta ekspor data ke Excel, PDF, dan cetak lewat DataTables.',['PHP','MariaDB','Bootstrap 5','DataTables','Signature Pad'],'images/projects/indata.png','https://pemweb.ifummi.my.id/kelasc/adindra_2430511048/login.php']] as $x){
   $pr=$p->projects()->create(['title'=>$x[0],'slug'=>Str::slug($x[0]),'category'=>$x[1],'icon'=>$x[2],'image_path'=>$x[5]??null,'url'=>$x[6]??null,'description'=>$x[3],'sort'=>++$k]);
   $pr->technologies()->sync(collect($x[4])->map(fn($t)=>Technology::firstOrCreate(['name'=>$t])->id));}
 }
}
