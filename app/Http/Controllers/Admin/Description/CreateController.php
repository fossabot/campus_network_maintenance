<?php

namespace App\Http\Controllers\Admin\Description;

use App\Http\Controllers\Controller;
use App\Models\RepairUserDescription;
use App\Models\Type;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function create(Request $request)
    {
        if ($this->role() != 9 && $request->input('type_id') != $this->type()) {
            return response()->json('没有此操作的权限。', 500);
        }

        Type::findOrFail($request->input('type_id'));

        if (mb_strlen($request->input('description')) <= 0) {
            return response()->json('故障类别 不得为空。', 422);
        }

        if ($this->checkDescriptionUnique($request)) {
            return response()->json('故障类别 已经存在。', 422);
        }

        if ($this->attemptCreate($request)) {
            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }

    protected function checkDescriptionUnique(Request $request)
    {
        return (bool)RepairUserDescription::whereTypeId($request->input('type_id'))->whereDescription($request->input('description'))->first();
    }

    protected function attemptCreate(Request $request)
    {
        return RepairUserDescription::insert($request->only(['type_id', 'description', 'admin_description']));
    }
}
