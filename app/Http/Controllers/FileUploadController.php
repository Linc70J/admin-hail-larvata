<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileUploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $file = $request->file('fileData');
        $path = $file->store('tmp', 'public');
        return response()->json(['message' => '上傳成功', 'data' => [
            "id" => null,
            "type" => 'tmp',
            "file_name" => $file->getClientOriginalName(),
            "url" => $path
        ]]);
    }
}
