<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Theme;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $asset = [];

    public function __construct()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Theme::asset()->add('page-asset', $this->asset, ['script', 'style']);
    }

    public function redirectFromType($route, $result, $key = 0, $type = 'default')
    {
        /** @var Request $request */
        switch ($type) {
            case 'create':
                return redirect()->route("${route}.create")->with($result);
            case 'exit':
                return redirect()->route("${route}.index")->with($result);
            default:
                return redirect()->route("${route}.edit", $key)->with($result);
        }
    }
}
