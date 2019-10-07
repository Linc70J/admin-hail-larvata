<?php

namespace App\Http\Controllers;

use App\Models\TopicCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;
use Theme;

class TopicCategoryController extends Controller
{
    protected $asset = [
        'css/datatables.bundle.css',
        'js/datatables.bundle.js',
        'css/vendor.css',
        'js/vendor.js',
        'css/l-module.css',
        'js/l-module.js',
        'js/topic_category.js',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Theme::of('topic_categories.index')->render();
    }

    /**
     * Query data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function query(Request $request)
    {
        $data = TopicCategory::query();

        if ($value = $request->get('text_search', false))
            $data->where(function (Builder $query) use ($value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%");
            });

        return datatables()->eloquent($data)->addColumns([])->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = new TopicCategory();
        return Theme::of('roles.form', compact('data'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = TopicCategory::findOrFail($id);
        return Theme::of('roles.form', compact('data'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
