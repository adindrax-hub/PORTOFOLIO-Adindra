<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration{
 private function owned(Blueprint $t){$t->id();$t->foreignId('profile_id')->constrained()->cascadeOnDelete();}
 public function up():void{
  Schema::create('profiles',function(Blueprint $t){$t->id();$t->string('full_name');$t->string('headline');$t->text('bio');$t->text('about');$t->string('location')->nullable();$t->string('photo_path')->nullable();$t->string('cv_path')->nullable();$t->json('taglines')->nullable();$t->timestamps();});
  Schema::create('contacts',function(Blueprint $t){$this->owned($t);$t->string('type');$t->string('label');$t->string('value');$t->string('url');$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('interests',function(Blueprint $t){$this->owned($t);$t->string('name');$t->string('icon')->default('code');$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('educations',function(Blueprint $t){$this->owned($t);$t->string('institution');$t->string('degree');$t->string('period');$t->unsignedSmallInteger('start_year')->nullable();$t->text('description')->nullable();$t->json('tags')->nullable();});
  Schema::create('experiences',function(Blueprint $t){$this->owned($t);$t->string('position');$t->string('company');$t->string('period');$t->unsignedSmallInteger('start_year')->nullable();$t->text('description')->nullable();$t->json('tags')->nullable();});
  Schema::create('organizations',function(Blueprint $t){$this->owned($t);$t->string('name');$t->string('position');$t->string('period');$t->unsignedSmallInteger('start_year')->nullable();$t->text('description')->nullable();});
  Schema::create('skill_categories',function(Blueprint $t){$this->owned($t);$t->string('name');$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('skills',function(Blueprint $t){$t->id();$t->foreignId('skill_category_id')->constrained()->cascadeOnDelete();$t->string('name');$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('projects',function(Blueprint $t){$this->owned($t);$t->string('title');$t->string('slug')->unique();$t->string('category');$t->string('icon');$t->string('image_path')->nullable();$t->text('description');$t->string('url')->nullable();$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('technologies',function(Blueprint $t){$t->id();$t->string('name')->unique();});
  Schema::create('project_technology',function(Blueprint $t){$t->foreignId('project_id')->constrained()->cascadeOnDelete();$t->foreignId('technology_id')->constrained()->cascadeOnDelete();$t->primary(['project_id','technology_id']);});
  Schema::create('certificates',function(Blueprint $t){$this->owned($t);$t->string('title');$t->string('issuer');$t->string('year');$t->string('image_path')->nullable();$t->string('credential_url')->nullable();$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('achievements',function(Blueprint $t){$this->owned($t);$t->string('title');$t->text('description')->nullable();$t->string('year')->nullable();$t->unsignedSmallInteger('sort')->default(0);});
  Schema::create('messages',function(Blueprint $t){$t->id();$t->string('name');$t->string('email');$t->text('body');$t->boolean('is_read')->default(false);$t->timestamps();});
 }
 public function down():void{foreach(['messages','achievements','certificates','project_technology','technologies','projects','skills','skill_categories','organizations','experiences','educations','interests','contacts','profiles'] as $x)Schema::dropIfExists($x);}
};
