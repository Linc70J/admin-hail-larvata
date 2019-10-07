<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationFormRequest;
use App\Models\User;
use DB;
use Exception;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Log;
use Response;
use Spatie\Permission\Models\Role;
use Str;
use Theme;

class UserController extends Controller
{
    protected $asset = [
        'css/datatables.bundle.css',
        'js/datatables.bundle.js',
        'css/vendor.css',
        'js/vendor.js',
        'css/l-module.css',
        'js/l-module.js',
        'js/user.js',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Theme::of('users.index')->render();
    }

    /**
     * Query data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function query(Request $request)
    {
        $data = User::with('roles', 'permissions');

        if ($value = $request->get('email', false))
            $data->where('email', 'like', "%{$value}%");

        if ($value = $request->get('name', false))
            $data->where('name', 'like', $value);

        return datatables()->eloquent($data)->addColumns(['display_status'])->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = new User();
        return Theme::of('users.create', compact('data'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRegistrationFormRequest $request
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store(UserRegistrationFormRequest $request)
    {
        /** @var Model $data */
        DB::beginTransaction();
        try {
            event(new Registered($data = User::create($request->all() + ['password' => Hash::make('')])));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            if (app()->isProduction())
                return back()->with(['errors' => [], 'message' => '儲存失敗'])->withInput($request->input());
            return back()->with(['errors' => [$e->getMessage()], 'message' => '儲存失敗'])->withInput($request->input());
        }

        $redirectType = $request->get('redirect-type', 'default');
        return $this->redirectFromType('users', ['message' => '儲存成功'], $data->getKey() ?? 0, $redirectType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $tab = $request->get('tab', 'personal-information');
        $roles = Role::all();
        return Theme::of('users.form', compact('data', 'tab', 'roles'))->render();
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
        $tab = $request->get('tab', 'personal-information');
        DB::beginTransaction();
        try {
            $data = User::findOrFail($id);
            switch ($tab) {
                case 'personal-information':
                    $data->update($request->only(['name', 'password', 'introduction', 'contact_phone']));
                    $data->avatar = $request->get('avatar', '');
                    break;
                case 'settings':
                    $data->syncRoles($request->get('roles', []));
                    $data->syncPermissions($request->get('permissions', []));
                    $data->update($request->only(['enabled', 'email_notification']));
                    break;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            if (app()->isProduction())
                return back()->with(['errors' => [], 'message' => '儲存失敗'])->withInput($request->input());
            return back()->with(['errors' => [$e->getMessage()], 'message' => '儲存失敗'])->withInput($request->input());
        }

        return redirect()->route("users.edit", [$id, 'tab' => $tab])->with(['message' => '儲存成功']);
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
            User::destroy($ids);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if (app()->isProduction())
                return response()->json(['errors' => [], 'message' => '刪除失敗']);
            return response()->json(['errors' => [$e->getMessage()], 'message' => '刪除失敗']);
        }
        return response()->json(['message' => '刪除成功']);
    }

    /**
     * Change or reset the given user's password.
     *
     * @param Request $request
     * @param User $user
     * @return void
     * @throws ValidationException
     */
    protected function changePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8',
        ]);
        $user->password = Hash::make($request->get('password'));

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return redirect()->route("users.edit", [$user->id, 'tab' => 'change-password'])->with(['message' => '密碼變更成功']);
    }
}
