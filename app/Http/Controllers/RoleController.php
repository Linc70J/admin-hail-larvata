<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;
use Response;
use Spatie\Permission\Models\Role;
use Theme;

class RoleController extends Controller
{
    protected $asset = [
        'css/datatables.bundle.css',
        'js/datatables.bundle.js',
        'css/vendor.css',
        'js/vendor.js',
        'css/l-module.css',
        'js/l-module.js',
        'js/role.js',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Theme::of('roles.index')->render();
    }

    /**
     * Query data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function query(Request $request)
    {
        $data = Role::with('permissions');

        if ($value = $request->get('role_name', false))
            $data->where('name', 'like', "%{$value}%");

        if ($value = $request->get('permission_name', false))
            $data->whereHas('permissions', function (Builder $query) use ($value) {
                $query->where('display_name', 'like', "%{$value}%");
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
        $data = new Role();
        return Theme::of('roles.form', compact('data'))->render();
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
        /** @var Role $data */
        DB::beginTransaction();
        try {
            $data = Role::create($request->only(['name']));
            $data->givePermissionTo($request->get('permissions', []));
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
        $data = Role::findOrFail($id);
        return Theme::of('roles.form', compact('data'))->render();
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
        /** @var Role $data */
        DB::beginTransaction();
        try {
            $data = Role::findOrFail($id);
            $data->syncPermissions($request->get('permissions', []));
            $data->update($request->only(['name']));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            if (app()->isProduction())
                return back()->with(['errors' => [], 'message' => '儲存失敗'])->withInput($request->input());
            return back()->with(['errors' => [$e->getMessage()], 'message' => '儲存失敗'])->withInput($request->input());
        }

        $redirectType = $request->get('redirect-type', 'default');
        return $this->redirectFromType('roles', ['message' => '儲存成功'], $id, $redirectType);
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
            Role::destroy($ids);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if (app()->isProduction())
                return response()->json(['errors' => [], 'message' => '刪除失敗']);
            return response()->json(['errors' => [$e->getMessage()], 'message' => '刪除失敗']);
        }
        return response()->json(['message' => '刪除成功']);
    }
}
