<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model{
 protected $table='projects';protected $guarded=[];public $timestamps=false;
 public function technologies(){return $this->belongsToMany(Technology::class,'project_technology');}
}
