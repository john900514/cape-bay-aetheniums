<?php

namespace App\Models\LibraryOfBabble;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Library extends Model
{
    use CrudTrait, RevisionableTrait, SoftDeletes, Uuid;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'icon', 'listing_route', 'client_id', 'permitted_role', 'permitted_abilities',
        'desc', 'active', 'misc'
    ];

    protected $casts = [
        'misc' => 'array'
    ];

    public function identifiableName()
    {
        return $this->name;
    }

    public function projects()
    {
        return $this->hasMany('App\Models\LibraryOfBabble\Project', 'library_id', 'id');
    }

    public function projects_with_topics()
    {
        return $this->projects()->with('topics');
    }

    public function projects_with_topics_and_articles()
    {
        return $this->projects()->with('topics_with_articles');
    }

    public function getSystemUserId()
    {
        return is_null(backpack_user()) ? 'System' : backpack_user()->id;
    }
}
