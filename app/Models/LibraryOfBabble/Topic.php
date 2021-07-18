<?php

namespace App\Models\LibraryOfBabble;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Topic extends Model
{
    use CrudTrait, RevisionableTrait, SoftDeletes, Uuid;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'icon', 'listing_route', 'project_id', 'permitted_role', 'permitted_abilities',
        'desc', 'active', 'misc'
    ];

    protected $casts = [
        'misc' => 'array'
    ];

    public function identifiableName()
    {
        return $this->name;
    }

    public function articles()
    {
        return $this->hasMany('App\Models\LibraryOfBabble\Article', 'topic_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id')
                    ->with('library');
    }

    public function open_listing_route($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="'.$this->listing_route.'?topic='.$this->id.'" data-toggle="tooltip" title="Send the user to the '.$this->name.' Topic page."><i class="la la-search"></i> Open</a>';
    }

    public function getSystemUserId()
    {
        return is_null(backpack_user()) ? 'System' : backpack_user()->id;
    }
}
