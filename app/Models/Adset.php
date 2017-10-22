<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 22 Oct 2017 19:36:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Adset
 * 
 * @property int $id
 * @property int $campaign_id
 * @property string $interest_query
 * @property string $country_digraph_array
 * @property int $bid_amount
 * @property int $daily_budget
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon $end_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\User $user
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
		'interest_query',
		'country_digraph_array',
		'bid_amount',
		'adset_name',
		'daily_budget',
		'start_time',
		'end_time',
        'ref',
		'user_id'
	];

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}
}
