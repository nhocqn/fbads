<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Campaign as CampaignModel;
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
use DateTime;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;
use Illuminate\Support\Facades\Log;


class CampaignController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

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
            $campaigns = CampaignModel::paginate($perPage);
        } else {
            $campaigns = CampaignModel::paginate($perPage);
        }

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('campaigns.create');
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
            //        / Initialize a new Session and instantiate an API object
            Api::init(
                env('FACEBOOK_APP_ID', null),
                env('FACEBOOK_APP_SECRET', null),

                auth()->user()->access_token // Your user access token
            );
            $requestData = $request->all();
            $acct_id = env('AD_ACCOUNT_ID', null);
            if ($acct_id) {
                $campaign = new Campaign(null, "act_$acct_id");
                $campaign->setData(array(
                    CampaignFields::NAME => $request->name,
                    CampaignFields::OBJECTIVE => CampaignObjectiveValues::LINK_CLICKS,
                ));

                $campaign->create(array(
                    Campaign::STATUS_PARAM_NAME => Campaign::STATUS_PAUSED,
                ));
                $res = $campaign->exportAllData();
                $requestData['ref'] = $res['id'];
                $requestData['user_id'] = auth()->user()->id;
                CampaignModel::create($requestData);
                $this->flashSuccess("Campaign Added!");
                return redirect('campaigns');

            }
            $this->flashError("Invalid Account ID");
            return redirect('campaigns');
        } catch (\Exception $e) {
            $this->flashError("Error:: " . $e->getMessage());
            return redirect('campaigns');
        }
    }

    public function create_adset(Request $request)
    {
        $interest_query = 'baseball';
        $country_digraph_array = array('US');
        $campaign_id = '<CAMPAIGN_ID>';
        $adset_name = 'name';
        $bid_amount = '3';
        $daily_budget = '10';
        $start_time = (new \DateTime("+1 week"))->format(\DateTime::ISO8601);
        $end_time = (new \DateTime("+2 week"))->format(DateTime::ISO8601);


        try {
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


                $this->flashSuccess("Campaign AdSet Added!");
                return redirect()->back();

            }
            $this->flashError("Invalid Account ID");
            return redirect()->back();
        } catch (\Exception $e) {
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
        $campaign = CampaignModel::findOrFail($id);

        return view('campaigns.show', compact('campaign'));
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
        $campaign = CampaignModel::findOrFail($id);

        return view('campaigns.edit', compact('campaign'));
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

        $campaign = CampaignModel::findOrFail($id);
        $campaign->update($requestData);

        return redirect('campaigns')->with('flash_message', 'campaigns updated!');
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
        CampaignModel::destroy($id);

        return redirect('campaigns')->with('flash_message', 'campaigns deleted!');
    }
}
