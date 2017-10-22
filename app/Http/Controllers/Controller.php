<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function flashError($message)
    {
        session()->flash('alert-danger', $message);
    }

    public function flashInfo($message)
    {
        session()->flash('alert-info', $message);
    }

    public function flashSuccess($message)
    {
        session()->flash('alert-success', $message);
    }

}
