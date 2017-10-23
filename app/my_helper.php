<?php

function app_constants()
{
    return [
        'TOKEN_EXPIRED' => 'You session has expired, please login to renew your session',


//        Member
        'INVALID_MEMBER' => "The member does not exist",
        'PASSWORD_CHANGE_SUCCESSFUL' => "Password change successful.",
        'INVALID_PASSWORD' => 'The password you specified does not match your registered password, please try again with the right password.',
        'INVALID_OLD_PASSWORD' => 'The old password your specified does not match your registered password, please try again with the right password.',
        'INVALID_EMAIL' => "There is no account linked to the email you provided.",
        'MEM_PROFILE_UPDATED' => "Your profile has been updated successful",

//        Forgot Password
        'PASSWORD_RESET_LINK_SENT' => "Reset link has been sent to the email.",


//        AUTH

        'TOKEN_INVALIDATED' => 'Your session has expired, please log in to continue',
        'TOKEN_INVALID' => 'Illegal access. Please log in or register',
        'TOKEN_GEN' => 'Successfully logged you into the app',
        'INVALID_CREDENTIALS' => 'The login credentials you used is not valid, please check and retry.',
        'TOKEN_REFRESHED' => 'Your session has been refreshed.',
        'MEMBER' => 'Member details',
        'MEMBER_NOT_FOUND' => 'Member details does not exist',
        'TOKEN_CREATION_ERR' => 'We are sorry but we could not log you into the app. A group of experts are already on this matter. ',


//        MISCELLANEOUS
        'PROCESSING' => 'The action is being processed and would be resolved soon.',

        'RESET_EMAIL_SENT' => 'The email reset link has been successfully sent to your email. Use the link provided in the email to reset your password. ',
        'EMAIL_FROM' => "Event Hub",

//        CODE
        'VALIDATION_EXCEPTION_CODE' => '402',
        'TOKEN_INVALID_CODE' => '401',
        'TOKEN_INVALIDATED_CODE' => '406',
        'EXCEPTION_CODE' => '500',

//       Exceptions
        'VALIDATION_EXCEPTION' => 'You did not fill one or more required fields in the form. Please fill all the required fields.',
        'INVALID_EMAIL_EXCEPTION' => 'We could not send a reset link to the email because the email does not have an account attached to it.',
        'REG_VALIDATION_EXCEPTION' => 'The email you chose already has an account. Try logging into the app with your email  and retry your registration again.',
        'EXCEPTION' => 'This is embarrassing. Something went wrong while trying to process your request but a group of experts are already on this matter.',
    ];
}


function generateRandomString($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }


    return $randomString;
}


function isValidEmail($email)
{
    return (boolean)filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
}


function sendEmail($message_data, $subject, $from, $to, $type = null)
{
    if (!$type) {
        $type = "default";
    }
    $info['message'] = $message_data;
    $info['from'] = $from;
    $info['email'] = $to;
    $info['subject'] = $subject;


    \Illuminate\Support\Facades\Mail::send('emails.' . $type, compact('message_data', 'info'), function ($message) use ($info) {
        $message->from(getAppEmail(), getAppName());
        $message->bcc($info['email'])->subject($info['subject']);
    });

}

function getAppName()
{
    return "Ad Manager";
}

function yourtubeVidEmbeder($url)
{

    $slit = explode('/', $url);
    if (count($slit) - 1 >= 0) {
        $main_id = $slit[count($slit) - 1];
        unset($slit[count($slit) - 1]);
        $new_url = implode('/', $slit) . '/embed/' . $main_id;
        return str_replace(['youtu.be'], ['youtube.com'], $new_url);

    }
    return "";
}

function getAppEmail()
{
    return "ndu4george@gmail.com";
}

function search_query_constructor($searchString, $col)
{
    $dataArray = (array_filter(explode(" ", trim($searchString))));
    $constructor_sql = "(";
    if (count($dataArray) < 1) {
        return " 1 ";
    }
    if (is_array($col)) {
        foreach ($col as $col_name) {
            if ($col_name !== $col[0]) {
                $constructor_sql .= " OR ";
            }
            for ($i = 0; $i < count($dataArray); $i++) {
                if (count($dataArray) - 1 === $i) {
                    $constructor_sql .= "$col_name LIKE '%{$dataArray[$i]}%' ";
                } else {
                    $constructor_sql .= "$col_name LIKE '%{$dataArray[$i]}%' OR ";
                }
            }
        }
    } else {
        for ($i = 0; $i < count($dataArray); $i++) {
            if (count($dataArray) - 1 === $i) {
                $constructor_sql .= "$col LIKE '%{$dataArray[$i]}%' ";
            } else {
                $constructor_sql .= "$col LIKE '%{$dataArray[$i]}%' OR ";
            }
        }
    }
    $constructor_sql .= ")";
    return $constructor_sql;
}

function multi_unset($array, $keys)
{
    if (is_array($array)) {
        foreach ($keys as $key) {
            unset($array[$key]);
        }

        return $array;

    } else {
        return null;
    }
}

function getAllCampaigns()
{
    return \App\Models\Campaign::where('user_id', auth()->user()->id)->pluck('name', 'id')->toArray();
}

function getAllAdsets()
{
    return \App\Models\Adset::pluck('adset_name', 'id')->toArray();
}

function getAllPostVideos()
{
    return \App\Models\PostVideo::all();
}

function getAllPostImages()
{
    return \App\Models\PostImage::all();
}

function encrypt_decrypt($action, $string)
{
    try {

        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'H899JHShjdfhjhejkse@14447DP';
        $secret_iv = 'TYEHVn0dUIK888JSBGDD';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;

    } catch (Exception $e) {
        return false;
    }
}

