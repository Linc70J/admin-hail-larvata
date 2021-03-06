<?php

namespace App\Http\Controllers;

use Response;
use Theme;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Theme::of('settings.index')->render();
    }
}
