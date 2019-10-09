<?php

namespace App\Http\Controllers;

use Response;
use Theme;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Theme::of('dashboard')->render();
    }
}
