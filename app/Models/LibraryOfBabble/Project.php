<?php

namespace App\Models\LibraryOfBabble;

use App\Models\LibraryOfBabble\Library;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Venturecraft\Revisionable\RevisionableTrait;

class Project extends Model
{
    use CrudTrait, RevisionableTrait, SoftDeletes, Uuid;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'icon', 'listing_route', 'library_id', 'permitted_role', 'permitted_abilities',
        'desc', 'active', 'misc'
    ];

    protected $casts = [
        'misc' => 'array'
    ];

    public function identifiableName()
    {
        return $this->name;
    }

    public function topics()
    {
        return $this->hasMany('App\Models\LibraryOfBabble\Topic', 'project_id', 'id');
    }

    public function topics_with_articles()
    {
        return $this->topics()->with('articles');
    }

    public function library()
    {
        return $this->belongsTo(Library::class, 'library_id', 'id');
    }

    public function open_listing_route($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="'.$this->listing_route.'" data-toggle="tooltip" title="Send the user to the '.$this->name.' Project page."><i class="la la-search"></i> Open</a>';
    }

    public function getSystemUserId()
    {
        return is_null(backpack_user()) ? 'System' : backpack_user()->id;
    }
}
