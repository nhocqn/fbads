<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 22:17:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Adset
 * 
 * @property int $id
 * @property int $campaign_id
 * @property string $adset_name
 * @property string $interest_query
 * @property string $country_digraph_array
 * @property int $bid_amount
 * @property int $daily_budget
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon $end_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $ref
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $ad_images
 *
 * @package App\Models
 */
class Adset extends Eloquent
{
	protected $casts = [
		'campaign_id' => 'int',
		'bid_amount' => 'int',
		'daily_budget' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'start_time',
		'end_time'
	];

	protected $fillable = [
		'campaign_id',
		'adset_name',
		'interest_query',
		'country_digraph_array',
		'bid_amount',
		'daily_budget',
		'start_time',
		'end_time',
		'user_id',
		'ref'
	];

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function ad_images()
	{
		return $this->hasMany(\App\Models\AdImage::class);
	}
}
