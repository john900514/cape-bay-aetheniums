<?php

namespace App\Models\LibraryOfBabble;

use App\Models\Content\Page;
use App\Models\LibraryOfBabble\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Article extends Model
{
    use CrudTrait, RevisionableTrait, SoftDeletes, Uuid;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'icon', 'listing_route', 'topic_id', 'permitted_role', 'permitted_abilities',
        'desc', 'active', 'misc'
    ];

    protected $casts = [
        'misc' => 'array'
    ];

    public function identifiableName()
    {
        return $this->name;
    }

    public function page_post()
    {
        $results = false;
        if(array_key_exists('page_slug', $this->misc))
        {
            $page_post_slug = $this->misc['page_slug'];
            $page = Page::whereSlug($page_post_slug)->first();

            if(!is_null($page))
            {
                $results = $page->toArray();
            }
        }

        return $results;
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id')
                ->with('project');
    }

    public function getSystemUserId()
    {
        return is_null(backpack_user()) ? 'System' : backpack_user()->id;
    }
}
