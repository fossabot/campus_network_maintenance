<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    /**
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $admin = Admin::findOrFail($request->input('id'));

        if ($this->id() != $admin->id && $this->role() <= $request->input('role_id')) {
            return response()->json('没有此操作的权限。', 403);
        }

        if ($this->role() != 9 && $request->input('type_id') != $this->type()) {
            return response()->json('没有此操作的权限。', 403);
        }

        if ($this->attemptUpdate($admin, $request)) {
            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param Model         $admin
     * @param UpdateRequest $request
     *
     * @return bool
     */
    protected function attemptUpdate(Model $admin, UpdateRequest $request)
    {
        $data = array_merge($request->only([
            'type_id', 'name', 'mobile', 'company',
        ]), [
            'role_id' => $request->input('role_id') ?: 1,
        ]);

        if ($request->input('password')) {
            $data = array_merge($data, ['password' => Hash::make($request->input('password'))]);

            if (session('admin.id') == $admin->id) {
                session()->flush();
            }
        }

        return $admin->forceFill($data)->save();
    }
}
