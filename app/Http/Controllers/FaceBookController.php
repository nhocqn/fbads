<?php

namespace App\Http\Controllers;

use App\User;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FaceBookController extends Controller
{
    public function fb_login(LaravelFacebookSdk $fb)
    {
        // Send an array of permissions to request
        $login_url = $fb->getLoginUrl();

        // Obviously you'd do this in blade :)
        echo '<a href="' . $login_url . '"> with Facebook</a>';
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

        return redirect('/home')->with('message', 'Successfully logged in with Facebook');
    }
}
