<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Technology extends Model{
 protected $table='technologies';protected $guarded=[];public $timestamps=false;
 public function projects(){return $this->belongsToMany(Project::class,'project_technology');}
}
