<?php

namespace App\Models\LibraryOfBabble;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Silber\Bouncer\BouncerFacade as Bouncer;
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

    public static function crud_filter_menu() : array
    {
        $model = new self;
        return Cache::remember(backpack_user()->id.'-all_active_libraries', (60 * 10), function () use ($model) {
            $results = [];
            $libs = $model->whereActive(1)->get();

            if(count($libs) > 0)
            {
                foreach ($libs as $lib)
                {
                    $valid = false;
                    if(!is_null($lib->permitted_role))
                    {
                        if(Bouncer::is(backpack_user())->a($lib->permitted_role))
                        {
                            if(!is_null($lib->permitted_abilities))
                            {
                                $valid = backpack_user()->can($lib->permitted_abilities);
                            }
                            else
                            {
                                $valid = true;
                            }
                        }
                    }
                    elseif(!is_null($lib->permitted_abilities))
                    {
                        $valid = backpack_user()->can($lib->permitted_abilities);
                    }
                    else
                    {
                        $valid = true;
                    }

                    if($valid)
                    {
                        $results[$lib->id] = $lib->name;
                    }

                }
            }

            return $results;
        });
    }
}
