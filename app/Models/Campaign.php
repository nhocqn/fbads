<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 13:56:41 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Campaign
 * 
 * @property int $id
 * @property string $name
 * @property string $objective
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * 
 * @property \App\Models\User $user
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
//		'objective',
		'user_id',
		'ref'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
