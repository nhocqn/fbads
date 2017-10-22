<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 09:17:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Post
 * 
 * @property int $id
 * @property string $title
 * @property string $message
 * @property int $pushed_to_fb
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $facebook_posts
 * @property \Illuminate\Database\Eloquent\Collection $post_campaigns
 * @property \Illuminate\Database\Eloquent\Collection $post_images
 * @property \Illuminate\Database\Eloquent\Collection $post_videos
 *
 * @package App\Models
 */
class Post extends Eloquent
{
	protected $casts = [
		'pushed_to_fb' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'title',
		'message',
		'pushed_to_fb',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
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
}
