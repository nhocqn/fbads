<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AdVideo as AdVideoModel;
use FacebookAds\Api;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdCreativeObjectStorySpec;
use FacebookAds\Object\AdCreativeVideoData;
use FacebookAds\Object\AdVideo;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Fields\AdCreativeObjectStorySpecFields;
use FacebookAds\Object\Fields\AdCreativeVideoDataFields;
use FacebookAds\Object\Fields\AdVideoFields;
use FacebookAds\Object\Values\AdCreativeCallToActionTypeValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdVideoController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()

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
            $ad_videos = AdVideoModel::paginate($perPage);
        } else {
            $ad_videos = AdVideoModel::paginate($perPage);
        }

        return view('ad_videos.index', compact('ad_videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('ad_videos.create');
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
//            dd($requestData);
            $page_id = $request->page_id;
            $video_path = $request->video_path;
            $video_id = $request->video_id;
//            $path_array = explode('.', $video_path);
            $thumbnail_url = $request->thumbnail_url;
            $path_array_thum = explode('.', $thumbnail_url);

            $ad_creative_name = $request->ad_creative_name;

//            $tmp = tempnam(__DIR__, 'fbu');
//            $ext = end($path_array);
//            file_put_contents($tmp . "." . $ext, file_get_contents($video_path));

//            $tmp_thum = tempnam(__DIR__, 'fbuthum');
//            $ext_thum = end($path_array_thum);
//            file_put_contents($tmp_thum . "." . $ext_thum, file_get_contents($thumbnail_url));

            Api::init(
                env('FACEBOOK_APP_ID', null),
                env('FACEBOOK_APP_SECRET', null),

                auth()->user()->access_token // Your user access token
            );
            $acct_id = env('AD_ACCOUNT_ID', null);
            if ($acct_id) {
//                $video = new AdVideo(null, "act_$acct_id");
//                $video->{AdVideoFields::SOURCE} = $tmp . "." . $ext;
//                Log::info('b4 video create');
//                $video->create();
                Log::info('after video create');
//                $vidArray = $video->exportAllData();
//                $video_id = $vidArray['id'];

                // create the creative
                Log::info('at create the creative');
                $video_data = new AdCreativeVideoData();
                $video_data->setData(array(
                    AdCreativeVideoDataFields::IMAGE_URL => $thumbnail_url,
                    AdCreativeVideoDataFields::VIDEO_ID => $video_id,
                    AdCreativeVideoDataFields::CALL_TO_ACTION => array(
                        'type' => AdCreativeCallToActionTypeValues::LIKE_PAGE,
                        'value' => array(
                            'page' => $page_id,
                        ),
                    ),
                ));

                Log::info('at $object_story_spec');
                $object_story_spec = new AdCreativeObjectStorySpec();
                $object_story_spec->setData(array(
                    AdCreativeObjectStorySpecFields::PAGE_ID => $page_id,
                    AdCreativeObjectStorySpecFields::VIDEO_DATA => $video_data,
                ));

                $creative = new AdCreative(null, "act_$acct_id");
                Log::info('at creative');
                $creative->setData(array(
                    AdCreativeFields::NAME => $ad_creative_name,
                    AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
                ));
                Log::info('created creative');
                $creArr = $creative->create();
                Log::info('created creative');
                $requestData['ref'] = $creArr['id'];
                $requestData['video_id'] = $video_id;
                $requestData['user_id'] = auth()->user()->id;

                AdVideoModel::create($requestData);
                $this->flashSuccess("Video Ad Added!");
                return redirect()->back();
            }
            $this->flashError("Invalid Account ID");
            return redirect()->back();
        } catch (\Exception $e) {
            var_dump($e);
//            $this->flashError("Error:: " . $e->getMessage());
//            return redirect()->back();
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
        $ad_video = AdVideoModel::findOrFail($id);

        return view('ad_videos.show', compact('ad_video'));
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
        $ad_video = AdVideoModel::findOrFail($id);

        return view('ad_videos.edit', compact('ad_video'));
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

        $ad_video = AdVideoModel::findOrFail($id);
        $ad_video->update($requestData);

        return redirect('ad_videos')->with('flash_message', 'AdVideo updated!');
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
        AdVideoModel::destroy($id);

        return redirect('ad_videos')->with('flash_message', 'AdVideo deleted!');
    }
}
