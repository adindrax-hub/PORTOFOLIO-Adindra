<?php
namespace App\Http\Controllers;
use App\Models\Profile;
use Illuminate\Support\Str;
class HomeController extends Controller{
 public function index(){
  $p=Profile::with(['contacts','interests','educations','experiences','organizations','skillCategories.skills','projects.technologies','certificates','achievements'])->firstOrFail();
  $map=fn($rows,$icon,$title,$org)=>$rows->map(fn($x)=>['icon'=>$icon,'period'=>$x->period,'title'=>$x->$title,'org'=>$x->$org,'desc'=>$x->description,'tags'=>$x->tags??[],'y'=>$x->start_year]);
  $timeline=$map($p->educations,'grad','degree','institution')->concat($map($p->experiences,'brief','position','company'))->concat($map($p->organizations,'users','position','name'))->sortBy(fn($t)=>$t['y']??9999)->values();
  $file=fn($path)=>$path&&file_exists(public_path($path))?asset($path):null;
  $js=['name'=>$p->full_name,'role'=>$p->headline,'taglines'=>$p->taglines??[],'photo'=>$file($p->photo_path),
   'projects'=>$p->projects->map(fn($x)=>['slug'=>$x->slug,'t'=>$x->title,'c'=>$x->category,'i'=>$x->icon,'img'=>$file($x->image_path),'d'=>$x->description,'s'=>$x->technologies->pluck('name'),'u'=>$x->url?:'#'])->all(),
   'certs'=>$p->certificates->map(fn($x)=>[$x->title,$x->issuer,$x->year,$x->image_path?asset($x->image_path):null])->all()];
  return view('home',['profile'=>$p,'timeline'=>$timeline,'js'=>$js,'first'=>Str::before($p->full_name,' '),'c'=>$p->contacts->keyBy('type'),'cv'=>$file($p->cv_path)??'#']);
 }
}
