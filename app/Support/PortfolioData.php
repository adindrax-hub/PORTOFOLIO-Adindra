<?php
namespace App\Support;
use App\Models\{Profile,Skill,Project,Experience,Certificate};
class PortfolioData{
 public static function all():array{
  $p=Profile::firstOrFail();
  return ['name'=>$p->name,'role'=>$p->role,'bio'=>$p->bio,'about'=>$p->about,'email'=>$p->email,'gh'=>$p->github,'li'=>$p->linkedin,'cv'=>asset($p->cv_path),
   'interests'=>$p->interests,'edu'=>$p->education,
   'skills'=>Skill::orderBy('sort')->get()->map(fn($s)=>[$s->name,$s->category])->all(),
   'projects'=>Project::orderBy('sort')->get()->map(fn($x)=>['t'=>$x->title,'c'=>$x->category,'i'=>$x->icon,'d'=>$x->description,'s'=>$x->stack,'u'=>$x->url])->all(),
   'journey'=>Experience::orderBy('sort')->get()->map(fn($x)=>[$x->period,$x->title,$x->organization,$x->description])->all(),
   'certs'=>Certificate::orderBy('sort')->get()->map(fn($x)=>[$x->title,$x->issuer,$x->year])->all()];
 }
}
