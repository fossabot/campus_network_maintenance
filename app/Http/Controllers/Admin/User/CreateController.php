<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateController extends Controller
{
    /**
     * 修改维修人员
     *
     * @param CreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        if ($this->role() <= $request->input('role_id')) {
            return response()->json('没有此操作的权限。', 403);
        }

        if ($this->role() != 9 && $request->input('type_id') != $this->type()) {
            return response()->json('没有此操作的权限。', 403);
        }

        if ($this->checkUsernameUnique($request->input('username'))) {
            return response()->json('管理员帐号 已经存在。', 422);
        }

        if ($id = $this->attemptCreate($request)) {
            return response()->json($id, 200);
        }

        return response()->json('服务器错误', 500);
    }

    /**
     * @param $username
     *
     * @return bool
     */
    protected function checkUsernameUnique($username)
    {
        return (bool)Admin::whereUsername($username)->first();
    }

    /**
     * @param CreateRequest $request
     *
     * @return int
     */
    protected function attemptCreate(CreateRequest $request)
    {
        return Admin::insertGetId(array_merge($request->only([
            'type_id', 'username', 'name', 'mobile', 'company',
        ]), [
            'role_id'  => $request->input('role_id') ?: 1,
            'password' => Hash::make($request->input('password')),
        ]));
    }
}
