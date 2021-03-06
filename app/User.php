<?php

namespace App;

use App\Option;
use App\Activity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function answers()
    {
        return $this->belongsToMany(Option::class, 'answers');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function getActivityStatusForItem($item)
    {
        $activity = $this->activities
            ->where('item_id', $item->id)
            ->where('item_type', get_class($item))->last();

        return $activity ? $activity->type : null;
    }

}
