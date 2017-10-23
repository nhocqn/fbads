<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 22:17:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdImage
 * 
 * @property int $id
 * @property string $image_path
 * @property int $adset_id
 * @property string $object_url
 * @property string $ad_creative_body
 * @property string $ad_creative_title
 * @property string $ad_name
 * @property string $ref
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Adset $adset
 * @property \App\User $user
 *
 * @package App\Models
 */
class AdImage extends Eloquent
{
	protected $casts = [
		'adset_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'image_path',
		'adset_id',
		'object_url',
		'ad_creative_body',
		'ad_creative_title',
		'ad_name',
		'ref',
		'user_id'
	];

	public function adset()
	{
		return $this->belongsTo(\App\Models\Adset::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}
}
