<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AdImage as AdImageModel;
use App\Models\Adset;
use FacebookAds\Api;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdImage;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Fields\AdFields;
use FacebookAds\Object\Fields\AdImageFields;
use Illuminate\Http\Request;

class AdImageController extends Controller
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
            $ad_images = AdImageModel::paginate($perPage);
        } else {
            $ad_images = AdImageModel::paginate($perPage);
        }

        return view('ad_images.index', compact('ad_images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('ad_images.create');
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
            $image_path = $request->image_path;
            $object_url = $request->object_url;
            $ad_creative_body = $request->ad_creative_body;
            $ad_creative_title = $request->ad_creative_title;
            $ad_name = $request->ad_name;

            $adset = Adset::where('id', $request->adset_id)->first();

            $adset_id = $adset->ref;
            #ref

            Api::init(
                env('FACEBOOK_APP_ID', null),
                env('FACEBOOK_APP_SECRET', null),

                auth()->user()->access_token // Your user access token
            );
            $acct_id = env('AD_ACCOUNT_ID', null);
            if ($acct_id) {
                $image = new AdImage(null, "act_$acct_id");
                $image->{AdImageFields::FILENAME} = $image_path;

                $image->create();
                $image_hash = $image->{AdImageFields::HASH} . PHP_EOL;

                // First, upload the ad image that you will use in your ad creative
// Please refer to Ad Image Create for details.

// Then, use the image hash returned from above
                $creative = new AdCreative(null, "act_$acct_id");
                $creative->setData(array(
                    AdCreativeFields::TITLE => $ad_creative_title,
                    AdCreativeFields::BODY => $ad_creative_body,
                    AdCreativeFields::OBJECT_URL => $object_url,
                    AdCreativeFields::IMAGE_HASH => $image_hash,
                ));

// Finally, create your ad along with ad creative.
// Please note that the ad creative is not created independently, rather its
// data structure is appended to the ad group
                $ad = new Ad(null, "act_$acct_id");
                $ad->setData(array(
                    AdFields::NAME => $ad_name,
                    AdFields::ADSET_ID => $adset_id,
                    AdFields::CREATIVE => $creative,
                ));
                $ad->create(array(
                    Ad::STATUS_PARAM_NAME => Ad::STATUS_PAUSED,
                ));
                $adArr = $ad->exportAllData();
                $requestData['ref'] = $adArr['id'];
                $requestData['user_id'] = auth()->user()->id;

                \App\Models\AdImage::create($requestData);
                $this->flashSuccess("Image Ad Added!");
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
        $ad_image = AdImageModel::findOrFail($id);

        return view('ad_images.show', compact('ad_image'));
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
        $ad_image = AdImageModel::findOrFail($id);

        return view('ad_images.edit', compact('ad_image'));
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

        $ad_image = AdImageModel::findOrFail($id);
        $ad_image->update($requestData);

        return redirect('ad_images')->with('flash_message', 'AdImage updated!');
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
        AdImageModel::destroy($id);

        return redirect('ad_images')->with('flash_message', 'AdImage deleted!');
    }
}
