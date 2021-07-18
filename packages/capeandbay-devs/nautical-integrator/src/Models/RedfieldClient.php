<?php

namespace AnchorCMS\Nautical\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedfieldClient extends Model
{
    use SoftDeletes, Notifiable;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $connection = 'redfield';

    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getConn()
    {
        return $this->connection;
    }

    public static function getClientNameDropDown()
    {
        $results = [];

        $records = self::whereActive(1)->get();

        if(count($records) > 0)
        {
            foreach ($records as $client)
            {
                $results[$client->id] = $client->name;
            }
        }

        return $results;
    }
}
