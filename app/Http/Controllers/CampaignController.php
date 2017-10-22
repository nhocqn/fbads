<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Campaign as CampaignModel;
use Illuminate\Http\Request;

use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;


class CampaignController extends Controller
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

                CampaignModel::create($requestData);
                $this->flashSuccess("Campaign Added!");
                return redirect('campaigns');

            }
            $this->flashError("Invalid Accoutn ID");
            return redirect('campaigns');
        } catch (\Exception $e) {
            $this->flashError("Error:: " . $e->getMessage());
            return redirect('campaigns');
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
