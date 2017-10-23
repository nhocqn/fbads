<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 22:17:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdVideo
 * 
 * @property int $id
 * @property int $user_id
 * @property string $page_id
 * @property string $video_path
 * @property string $video_id
 * @property string $thumbnail_url
 * @property string $ad_creative_name
 * @property string $ref
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\User $user
 *
 * @package App\Models
 */
class AdVideo extends Eloquent
{
	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'page_id',
		'video_path',
		'video_id',
		'thumbnail_url',
		'ad_creative_name',
		'ref'
	];

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}
}
