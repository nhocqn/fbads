<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class User extends Authenticatable
{
    use Notifiable,SyncableGraphNodeTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'access_token'
    ];

    protected static $graph_node_field_aliases = [
        'id' => 'facebook_user_id',
//        'name' => 'full_name',
    ];

    protected $casts = [
        'facebook_user_id' => 'int'
    ];



    protected $fillable = [
        'name',
        'email',
        'password',
        'facebook_user_id',
        'access_token'
    ];
    public function adsets()
    {
        return $this->hasMany(\App\Models\Adset::class);
    }

    public function campaigns()
    {
        return $this->hasMany(\App\Models\Campaign::class);
    }

    public function facebook_posts()
    {
        return $this->hasMany(\App\Models\FacebookPost::class);
    }

    public function post_campaigns()
    {
        return $this->hasMany(\App\Models\PostCampaign::class);
    }

    public function post_images()
    {
        return $this->hasMany(\App\Models\PostImage::class);
    }

    public function post_videos()
    {
        return $this->hasMany(\App\Models\PostVideo::class);
    }

    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }
}
