<?php

namespace App\Http\Controllers;

use App\Models\FacebookPost;
use App\Models\Post;
use App\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FaceBookController extends Controller
{
    public $fb;

    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
        $this->middleware('auth')->except('fb_login', 'fb_callback');
    }

    public function fb_login()
    {
        $fb = $this->fb;
        // Send an array of permissions to request
        $login_url = $fb->getLoginUrl();

        return view('auth/login')->with(compact('login_url'));
    }

    // Endpoint that is redirected to after an authentication attempt
    public function fb_callback(LaravelFacebookSdk $fb)
    {
        // Obtain an access token.
        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch (FacebookSDKException $e) {
            $this->flashError($e->getMessage());
            return redirect()->back();
        }

        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (!$token) {
            // Get the redirect helper
            $helper = $fb->getRedirectLoginHelper();

            if (!$helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            $this->flashError($helper->getErrorReason() . "::: " . $helper->getErrorDescription());
            return redirect()->back();
        }

        if (!$token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $fb->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (FacebookSDKException $e) {
                $this->flashError($e->getMessage());
                return redirect()->back();
            }
        }

        $fb->setDefaultAccessToken($token);

        // Save for later
        Session::put('fb_user_access_token', (string)$token);

        // Get basic info on the user from Facebook.
        try {
            $response = $fb->get('/me?fields=id,name,email');
        } catch (FacebookSDKException $e) {
            $this->flashError($e->getMessage());
            return redirect()->back();
        }

        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();

        Log::info(print_r($facebook_user->asArray(), true));
        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        $user = User::createOrUpdateGraphNode($facebook_user);

        // Log the user into Laravel
        Auth::login($user);
        User::where('id', \auth()->user()->id)->update(['access_token' => (string)$token]);
        $this->flashSuccess("Successfully logged in with Facebook");

        return redirect('/home')->with('message', 'Successfully logged in with Facebook');
    }

    public function save_to_fb_feed($data, $response, $post_id, $page_id, $type)
    {
//type= 0 : feed, 1: image, 2 : video
        FacebookPost::create([
            'facebook_post_id' => $response['id'] ? $response['id'] : null,
            'post_id' => $post_id,
            'page_id' => $page_id,
            'type' => $type,
            'meta' => json_encode($data),
            'user_id' => \auth()->user()->id,
        ]);

    }

    public function video_upload($data, $post_id, $page_id)
    {
        $fb = $this->fb;

        $response = $fb->post("/$page_id/videos", $data, auth()->user()->access_token);
        $graphNode = $response->getGraphNode()->asArray();
        Log::info(print_r($graphNode, true));
        $this->save_to_fb_feed($data, $graphNode, $post_id, $page_id, 2);
        return $graphNode;
//        try {
//            $response = $fb->post('/me/videos', $data, auth()->user()->access_token);
//        } catch (FacebookResponseException $e) {
//            // When Graph returns an error
//            $this->flashError('Graph returned an error: ' . $e->getMessage());
//            return redirect()->back();
//        } catch (FacebookSDKException $e) {
//            // When validation fails or other local issues
//            $this->flashError('Facebook SDK returned an error: ' . $e->getMessage());
//            return redirect()->back();
//        }
//
//        $graphNode = $response->getGraphNode();
//        Log::info(print_r($graphNode, true));
//        $this->flashSuccess('Posted to facebook successfully!');
//        return redirect()->back();
    }

    public function image_upload($data, $post_id, $page_id)
    {
        $fb = $this->fb;
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->post("/$page_id/photos", $data, auth()->user()->access_token);
        $graphNode = $response->getGraphNode()->asArray();
        Log::info(print_r($graphNode, true));
        $this->save_to_fb_feed($data, $graphNode, $post_id, $page_id, 1);
        return $graphNode;
    }

    public function feed_upload($data, $post_id, $page_id)
    {
        $fb = $this->fb;
        $response = $fb->post("/$page_id/feed", $data, auth()->user()->access_token);
        $graphNode = $response->getGraphNode();
        Log::info(print_r($graphNode, true));
        $this->save_to_fb_feed($data, $graphNode, $post_id, $page_id, 0);
        return $graphNode;
    }

    public function fb_push_post($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.facebook', compact('post'));
    }

    public function push_upload(Request $request)
    {
        /*
       * video
       * $data = [
          'title' => $request->title,
          'description' => $request->description,
          'source' => $fb->videoToUpload($request->video_url),
      ];
       *
       *image
       * $data = [
          'message' => $request->message,
          'source' => $fb->fileToUpload($request->image_url)
      ];
       *  feed
       * $data = [
          'message' => $request->message,
          "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
          "picture" => "http://i.imgur.com/lHkOsiH.png",
          "name" => "How to Auto Post on Facebook with PHP",
          "caption" => "www.pontikis.net",
          "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."

      ];
       * */
        try {
//            dd($request->all());

            $this->validate($request, [
                'post_id' => 'required',
                'page_id' => 'required',
            ]);


            $reqData = $request->all();
            $fb = $this->fb;

            if (isset($reqData['feed_post']) && $reqData['feed_post'] == "on") {
                $data = [
                    'message' => $request->message ? $request->message : '',
                    "link" => $request->link ? $request->link : '',# "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
                    "picture" => $request->selected_image ? $request->selected_image : '',
                    "name" => $request->name ? $request->name : '',
                    "caption" => $request->caption ? $request->caption : '',
                    "description" => $request->dedscription ? $request->dedscription : '',
                ];

                $this->feed_upload($data, $request->post_id, $request->page_id);
                $this->flashInfo('Facebook feed post was successful');
            }

            if (isset($reqData['video_post']) && $reqData['video_post'] == "on") {
                $data = [
                    'title' => $request->title ? $request->title : '',
                    'description' => $request->description ? $request->description : "",
                    'source' => $request->selected_vid ? $fb->videoToUpload($request->selected_vid) : '',
                ];

                if ($data['source'] != '') {
                    $this->video_upload($data, $request->post_id, $request->page_id);
                    $this->flashSuccess('Facebook video post was successful');
                } else {

                    $this->flashInfo('Video Source was not added and could not make the post');

                }
            }


            if (isset($reqData['image_post']) && $reqData['image_post'] == "on") {
                $data = [
                    'message' => $request->message ? $request->message : "",
                    'source' => $request->selected_image ? $fb->fileToUpload($request->selected_image) : ''
                ];
                if ($data['source'] != '') {
                    $this->image_upload($data, $request->post_id, $request->page_id);
                    $this->flashSuccess('Facebook post was successful');
                } else {
                    $this->flashInfo(' Image Source was not added and could not make the post');
                }
            }
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            Log::info('Graph returned an error: ' . $e->getMessage());
            $this->flashError('Graph returned an error: ' . $e->getMessage());
            return redirect()->back();
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            Log::info('Facebook SDK returned an error: ' . $e->getMessage());
            $this->flashError('Facebook SDK returned an error: ' . $e->getMessage());
            return redirect()->back();
        } catch (\Exception $e) {
            // When validation fails or other local issues
            Log::info('App returned an error: ' . $e->getMessage());
            $this->flashError('App returned an error: ' . $e->getMessage());
            return redirect()->back();

        }

        Post::where('id', $request->post_id)->update([
            'pushed_to_fb' => 1
        ]);

        return redirect()->back();
    }


    public function getFeedPost(Request $request)
    {
        try {
            $fb = $this->fb;
            $data = [
                'message',
                "link",
                "picture",
                "name",
                "caption",
                "description",
            ];

            $response = $fb->get($request->face_bk_id . "?pretty=0&fields=" . implode(',', $data), auth()->user()->access_token);

            return json_encode($response->getGraphNode()->asArray());
        } catch (\Exception $e) {
            return json_encode(["Error " => $e->getMessage()]);
        }
    }

    public function getImagePost(Request $request)
    {
        try {


            $fb = $this->fb;
            $data = [
                'id',
                'source'
            ];

            $response = $fb->get($request->face_bk_id . "?pretty=0&fields=" . implode(',', $data), auth()->user()->access_token);

            return json_encode($response->getGraphNode()->asArray());
        } catch (\Exception $e) {
            return json_encode(["Error " => $e->getMessage()]);
        }
    }

    public function getVideoPost(Request $request)
    {
        try {
            $fb = $this->fb;
            $data = [
                'title',
                'description',
                'source',
            ];

            $response = $fb->get($request->face_bk_id . "?pretty=0&fields=" . implode(',', $data), auth()->user()->access_token);

            return json_encode($response->getGraphNode()->asArray());
        } catch (\Exception $e) {
            return json_encode(["Error " => $e->getMessage()]);
        }
    }
}
