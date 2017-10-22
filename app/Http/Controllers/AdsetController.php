<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Adset as AdsetModel;
use FacebookAds\Api;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\Search\TargetingSearchTypes;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $adsets = AdsetModel::paginate($perPage);
        } else {
            $adsets = AdsetModel::paginate($perPage);
        }

        return view('adsets.index', compact('adsets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('adsets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


        try {
            $this->validate($request, [
                'campaign_id' => 'required',
                'end_time' => 'required',
                'start_time' => 'required',
                'adset_name' => 'required',
                'country_digraph_array' => 'required',
                'daily_budget' => 'number|min:1',
            ]);


            $interest_query = $request->interest_query;
            $country_digraph_array = $request->country_digraph_array;
            $campaign_id = $request->campaign_id;
            $adset_name = $request->adset_name;
            $bid_amount = $request->bid_amount;
            $daily_budget = $request->daily_budget;
            $start_time = (new \DateTime($request->start_time))->format(\DateTime::ISO8601);
            $end_time = (new \DateTime($request->end_time))->format(\DateTime::ISO8601);


            //        / Initialize a new Session and instantiate an API object
            Api::init(
                env('FACEBOOK_APP_ID', null),
                env('FACEBOOK_APP_SECRET', null),

                auth()->user()->access_token // Your user access token
            );
            $acct_id = env('AD_ACCOUNT_ID', null);
            if ($acct_id) {

                // specify the interest
                $interest = TargetingSearch::search(
                    TargetingSearchTypes::INTEREST,
                    null,
                    $interest_query);

                // set the target
                $targeting = new Targeting();
                $targeting->{TargetingFields::GEO_LOCATIONS} =
                    array(
                        'countries' => $country_digraph_array
                    );
                $targeting->{TargetingFields::INTERESTS} = $interest;


                //  Define Budget, Billing, Optimization, and Duration


                $adset = new AdSet(null, "act_$acct_id");
                $adset->setData(array(
                    AdSetFields::NAME => $adset_name,
                    AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::REACH,
                    AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS,
                    AdSetFields::BID_AMOUNT => $bid_amount,
                    AdSetFields::DAILY_BUDGET => $daily_budget,
                    AdSetFields::CAMPAIGN_ID => $campaign_id,
                    AdSetFields::TARGETING => $targeting,
                    AdSetFields::START_TIME => $start_time,
                    AdSetFields::END_TIME => $end_time,
                ));
                $adset->create(array(
                    AdSet::STATUS_PARAM_NAME => AdSet::STATUS_PAUSED,
                ));


                // Set up Ad Creative
                $adsetArray = $adset->exportAllData();
                $requestData = $request->all();
                $requestData['ref'] = $adsetArray['id'];
                $requestData['country_digraph_array'] = json_encode($request->country_digraph_array);
                AdsetModel::create($requestData);
                $this->flashSuccess("Campaign AdSet Added!");
                return redirect()->back();

            }
            $this->flashError("Invalid Account ID");
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info("Error:: " . $e->getMessage());
            $this->flashError("Error:: " . $e->getMessage());
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $adset = AdsetModel::findOrFail($id);

        return view('adsets.show', compact('adset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $adset = AdsetModel::findOrFail($id);

        return view('adsets.edit', compact('adset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $adset = AdsetModel::findOrFail($id);
        $adset->update($requestData);

        return redirect('adsets')->with('flash_message', 'Adset updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        AdsetModel::destroy($id);

        return redirect('adsets')->with('flash_message', 'Adset deleted!');
    }
}
