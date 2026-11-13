<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Profile extends Model{
 protected $table='profiles';protected $guarded=[];protected $casts=['taglines'=>'array'];
 public function contacts(){return $this->hasMany(Contact::class)->orderBy('sort');}
 public function interests(){return $this->hasMany(Interest::class)->orderBy('sort');}
 public function educations(){return $this->hasMany(Education::class);}
 public function experiences(){return $this->hasMany(Experience::class);}
 public function organizations(){return $this->hasMany(Organization::class);}
 public function skillCategories(){return $this->hasMany(SkillCategory::class)->orderBy('sort');}
 public function projects(){return $this->hasMany(Project::class)->orderBy('sort');}
 public function certificates(){return $this->hasMany(Certificate::class)->orderBy('sort');}
 public function achievements(){return $this->hasMany(Achievement::class)->orderBy('sort');}
 
}
