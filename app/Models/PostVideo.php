<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 21 Oct 2017 16:32:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PostVideo
 * 
 * @property int $id
 * @property int $post_id
 * @property string $video_url
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\User $user
 * @property \App\Models\Post $post
 *
 * @package App\Models
 */
class PostVideo extends Eloquent
{
	protected $casts = [
		'post_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'post_id',
		'video_url',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function post()
	{
		return $this->belongsTo(\App\Models\Post::class);
	}
}
