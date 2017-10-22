<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 09:17:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FacebookPost
 * 
 * @property int $id
 * @property string $facebook_post_id
 * @property int $post_id
 * @property \Carbon\Carbon $created
 * @property \Carbon\Carbon $updated
 * @property string $meta
 * @property int $user_id
 * 
 * @property \App\Models\Post $post
 * @property \App\User $user
 *
 * @package App\Models
 */
class FacebookPost extends Eloquent
{

	protected $casts = [
		'post_id' => 'int',
		'user_id' => 'int'
	];


	protected $fillable = [
		'facebook_post_id',
		'post_id',
		'meta',
		'user_id'
	];

	public function post()
	{
		return $this->belongsTo(\App\Models\Post::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}
}
