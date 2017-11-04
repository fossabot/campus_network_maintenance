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

        if ($this->attemptUpdate($admin, $request)) {
            return response()->json('', 200);
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
        $data = $request->only(['name', 'mobile', 'company']);

        if ($request->input('password')) {
            $data = array_merge($data, ['password' => Hash::make($request->input('password'))]);

            if (session('admin.id') == $admin->id) {
                session()->flush();
            }
        }

        return $admin->update($data);
    }
}