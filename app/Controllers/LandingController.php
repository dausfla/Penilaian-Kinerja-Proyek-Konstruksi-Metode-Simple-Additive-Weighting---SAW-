<?php

namespace App\Controllers;

class LandingController extends BaseController
{
    public function index()
    {
        $isLoggedIn = (bool) session()->get('is_logged_in');
        $userNama   = session()->get('user_nama');

        return view('landing', [
            'isLoggedIn' => $isLoggedIn,
            'userNama'   => $userNama,
        ]);
    }
}
