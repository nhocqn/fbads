<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 22:17:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PostCampaign
 * 
 * @property int $id
 * @property string $campaign_name
 * @property int $post_id
 * @property string $identifier
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Post $post
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class PostCampaign extends Eloquent
{
	protected $casts = [
		'post_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'campaign_name',
		'post_id',
		'identifier',
		'user_id'
	];

	public function post()
	{
		return $this->belongsTo(\App\Models\Post::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
