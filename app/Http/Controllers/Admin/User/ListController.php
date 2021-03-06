<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class ListController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $users = Admin::where('role_id', '!=', 9)->where('id', '!=', $this->id())->orderByDesc('role_id')->orderBy('type_id');

        if ($this->role() != 9) {
            $users->where('type_id', $this->type());
        }

        return response()->json($users->get()->map([$this, 'transformer'])->toArray());
    }

    /**
     * @param Model $admin
     *
     * @return array
     */
    public function transformer(Model $admin)
    {
        /**
         * @var Admin $admin
         */
        return [
            'id'       => $admin->id,
            'role_id'  => $admin->role_id,
            'role'     => $admin->role,
            'type_id'  => $admin->type_id,
            'type'     => @$admin->type->name,
            'username' => $admin->username,
            'name'     => $admin->name,
            'mobile'   => $admin->mobile,
            'company'  => $admin->company,
        ];
    }
}
