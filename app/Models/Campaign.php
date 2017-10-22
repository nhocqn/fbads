<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 19:36:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Campaign
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $ref
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $adsets
 *
 * @package App\Models
 */
class Campaign extends Eloquent
{
	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'name',
		'user_id',
		'ref'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function adsets()
	{
		return $this->hasMany(\App\Models\Adset::class);
	}
}
