<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\TopicCategory;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;
use Response;
use Theme;

class TopicController extends Controller
{
    protected $asset = [
        'css/datatables.bundle.css',
        'js/datatables.bundle.js',
        'css/vendor.css',
        'js/vendor.js',
        'css/l-module.css',
        'js/l-module.js',
        'js/topic.js',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = TopicCategory::all();
        return Theme::of('topics.index', compact('categories'))->render();
    }

    /**
     * Query data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function query(Request $request)
    {
        // set sort
        $data = Topic::withOrder($request->get('order', 'default'));

        // set filter
        if ($value = $request->get('topic_category_id', false))
            $data->where('topic_category_id', $value);

        if ($value = $request->get('start_date', false))
            $data->whereDate('start_at', '>=', $value);

        if ($value = $request->get('end_date', false))
            $data->whereDate('start_at', '<=', $value);

        if ($value = $request->get('user_name', false))
            $data->whereHas('user', function (Builder $query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            });

        if ($value = $request->get('text_search', false))
            $data->where(function (Builder $query) use ($value) {
                $query->where('title', 'like', "%{$value}%")
                    ->orWhere('body', 'like', "%{$value}%");
            });

        return datatables()->eloquent($data)->addColumns(['display_status'])->toJson();
    }

    /**
     * Query data
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function order(Request $request)
    {
        DB::beginTransaction();
        try {
            switch ($request->get('type', null)) {
                case 'insert':
                    $old = Topic::findOrFail($request->get('id', null));

                    $count = Topic::withOrder('custom')->where('top', $old->top)->count();
                    $position = $request->get('position', 1);
                    $position = $position < 1 ? 0 : $position - 1;
                    $position = $position >= $count ? $count - 1 : $position;

                    $other = Topic::withOrder('custom')->where('top', $old->top)->skip($position)->first('order');

                    if ($old->order > $other->order) {
                        Topic::whereBetween('order', [$old->order, $other->order])
                            ->update(['order' => DB::raw('`order` + 1')]);
                    } elseif ($old->order <= $other->order) {
                        Topic::whereBetween('order', [$old->order, $other->order])
                            ->where('order', '!=', 0)
                            ->update(['order' => DB::raw('`order` - 1')]);
                    }

                    $old->order = $other->order;
                    $old->save();
                    break;
                case 'drag':
                    $ids = $request->get('ids', []);
                    $orders = $request->get('orders', []);
                    rsort($orders);
                    foreach ($ids as $key => $value)
                        Topic::where('id', $value)->update(['order' => $orders[$key]]);
                    break;
                default:
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['errors' => [$e->getMessage()], 'message' => '重新排序失敗']);
        }
        return response()->json(['message' => '重新排序成功']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = TopicCategory::all();
        $users = User::all();
        $data = new Topic();
        return Theme::of('topics.form', compact('data', 'users', 'categories'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store(Request $request)
    {
        /** @var Model $data */
        DB::beginTransaction();
        try {
            $data = Topic::create($request->all());
            $data->banner = $request->get('banner', '');
            $data->appendixes = $request->get('appendixes', []);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            if (app()->isProduction())
                return back()->with(['errors' => [], 'message' => '儲存失敗'])->withInput($request->input());
            return back()->with(['errors' => [$e->getMessage()], 'message' => '儲存失敗'])->withInput($request->input());
        }

        $redirectType = $request->get('redirect-type', 'default');
        return $this->redirectFromType('topics', ['message' => '儲存成功'], $data->getKey() ?? 0, $redirectType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $categories = TopicCategory::all();
        $users = User::all();
        $data = Topic::findOrFail($id);
        return Theme::of('topics.form', compact('data', 'users', 'categories'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        /** @var Model $data */
        DB::beginTransaction();
        try {
            $data = Topic::findOrFail($id);
            $data->update($request->all());
            $data->banner = $request->get('banner', '');
            $data->appendixes = $request->get('appendixes', []);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            if (app()->isProduction())
                return back()->with(['errors' => [], 'message' => '儲存失敗'])->withInput($request->input());
            return back()->with(['errors' => [$e->getMessage()], 'message' => '儲存失敗'])->withInput($request->input());
        }

        $redirectType = $request->get('redirect-type', 'default');
        return $this->redirectFromType('topics', ['message' => '儲存成功'], $id, $redirectType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function delete(Request $request)
    {
        $ids = $request->get('ids', []);

        try {
            Topic::destroy($ids);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if (app()->isProduction())
                return response()->json(['errors' => [], 'message' => '刪除失敗']);
            return response()->json(['errors' => [$e->getMessage()], 'message' => '刪除失敗']);
        }
        return response()->json(['message' => '刪除成功']);
    }
}
