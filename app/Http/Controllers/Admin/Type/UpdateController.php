<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeRequest;
use App\Models\Type;
use Illuminate\Database\Eloquent\Model;

class UpdateController extends Controller
{
    /**
     * 修改维修分类
     *
     * @param TypeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TypeRequest $request)
    {
        // 分类是否存在
        $type = Type::findOrFail($request->input('id'));

        // 检测是否重复
        if ($this->checkNameUnique($type->id, $request->input('name'))) {
            return response()->json('分类名称 已经存在。', 422);
        }

        // 尝试修改
        if ($this->attemptUpdate($type, $request)) {
            return response()->json('', 200);
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param $id
     * @param $name
     *
     * @return bool
     */
    protected function checkNameUnique($id, $name)
    {
        return (bool)Type::whereName($name)->whereKeyNot($id)->first();
    }

    /**
     * @param Model       $type
     * @param TypeRequest $request
     *
     * @return bool
     */
    protected function attemptUpdate(Model $type, TypeRequest $request)
    {
        return $type->update($request->only([
            'name', 'introduction', 'auto_complete_hours', 'auto_complete_stars', 'allow_user_create',
        ]));
    }
}
