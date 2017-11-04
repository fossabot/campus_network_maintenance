<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class DetailController extends Controller
{
    public function data($id)
    {
        return response()->json($this->transformer(Admin::findOrFail($id)), 200);
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
