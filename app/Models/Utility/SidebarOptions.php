<?php

namespace App\Models\Utility;

use App\Aggregates\Users\UserProfileAggregate;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class SidebarOptions extends Model
{
    use CrudTrait, Uuid, SoftDeletes;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'route', 'page_shown', 'menu_name', 'is_submenu', 'permitted_role',
        'permitted_abilities', 'active', 'order', 'icon', 'is_modal', 'is_standalone', 'is_post_action', 'action_url'
    ];

    public static function getSidebarOptions($page_shown = 'all')
    {
        $results = [];

        $options = self::where(function($query) {
            return $query->where('is_submenu', '=', 1)
                ->orWhere('is_standalone', '=', 1);
            }
            )->whereActive(1);

        if($page_shown != 'any')
        {
            $options = $options->where(function($query) use ($page_shown) {
                return $query->where('page_shown', '=', 'all')
                    ->orWhere('page_shown', '=', $page_shown);
            });
        }
        else
        {
            $options = $options->wherePageShown('all');
        }

        $options = $options->orderBy('order', 'ASC')
            ->get();

        if(count($options) > 0)
        {
            // Organize array
            // Make the options
            foreach ($options as $option)
            {
                if(Bouncer::is(backpack_user())->a($option->permitted_role))
                {
                    $results[] = $option;
                }
            }
        }

        return $results;
    }

    public static function getSubSidebarOptions($menu_name)
    {
        $results = [];

        $options = self::whereMenuName($menu_name)
            ->whereIsSubmenu(0)
            ->orderBy('order', 'ASC')
            ->get();

        if(count($options) > 0)
        {
            // Organize array
            // Make the options
            foreach ($options as $option)
            {
                if(Bouncer::is(backpack_user())->a($option->permitted_role))
                {
                    $results[] = $option;
                }
            }
        }

        return $results;
    }
}
