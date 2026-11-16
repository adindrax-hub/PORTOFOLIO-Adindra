<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $guarded = [];

    protected $casts = [
        'taglines' => 'array',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class)->orderBy('sort');
    }

    public function interests(): HasMany
    {
        return $this->hasMany(Interest::class)->orderBy('sort');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function skillCategories(): HasMany
    {
        return $this->hasMany(SkillCategory::class)->orderBy('sort');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('sort');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class)->orderBy('sort');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class)->orderBy('sort');
    }
}