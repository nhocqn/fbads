<?php

namespace App\Http\Controllers;

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

        Log::info(print_r($facebook_user, true));
        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        $user = User::createOrUpdateGraphNode($facebook_user);

        // Log the user into Laravel
        Auth::login($user);
        User::where('id', \auth()->user()->id)->update(['access_token' => (string)$token]);
        $this->flashSuccess("");

        return redirect('/home')->with('message', 'Successfully logged in with Facebook');
    }


    public function video_upload($data)
    {
        $fb = $this->fb;

        return $fb->post('/me/videos', $data, auth()->user()->access_token);

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

    public function image_upload($data)
    {
        $fb = $this->fb;
        // Returns a `Facebook\FacebookResponse` object
        return $response = $fb->post('/me/photos', $data, auth()->user()->access_token);

    }

    public function feed_upload($data)
    {
        $fb = $this->fb;
        return $response = $fb->post('/me/feed', $data, auth()->user()->access_token);
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
            dd($request->all());
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

                $this->feed_upload($data);
            }

            if (isset($reqData['video_post']) && $reqData['video_post'] == "on") {
                $data = [
                    'title' => $request->title ? $request->title : '',
                    'description' => $request->description ? $request->description : "",
                    'source' => $request->selected_video ? $fb->videoToUpload($request->selected_video) : '',
                ];

                if ($data['source'] != '') {
                    $this->video_upload($data);
                }
            }


            if (isset($reqData['image_post']) && $reqData['image_post'] == "on") {
                $data = [
                    'message' => $request->message ? $request->message : "",
                    'source' => $request->selected_image ? $fb->fileToUpload($request->selected_image) : ''
                ];
                if ($data['source'] != '') {
                    $this->image_upload($data);
                }
            }
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            $this->flashError('Graph returned an error: ' . $e->getMessage());
            return redirect()->back();
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            $this->flashError('Facebook SDK returned an error: ' . $e->getMessage());
            return redirect()->back();
        }



        $this->flashError('Facebook post was successful');
        return redirect()->back();
    }

}
