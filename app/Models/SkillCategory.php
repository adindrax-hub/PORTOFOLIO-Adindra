<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SkillCategory extends Model{
 protected $table='skill_categories';protected $guarded=[];public $timestamps=false;
 public function skills(){return $this->hasMany(Skill::class)->orderBy('sort');}
}
