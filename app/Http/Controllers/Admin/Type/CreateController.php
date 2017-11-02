<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Type\CreateRequest;
use App\Models\Type;

class CreateController extends Controller
{
    /**
     * @param CreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        if ($this->checkNameUnique($request->input('name'))) {
            return response()->json('分类名称 已经存在。', 422);
        }

        if ($id = $this->attemptCreate($request)) {
            return response()->json($id, 200);
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function checkNameUnique($name)
    {
        return (bool)Type::whereName($name)->first();
    }

    /**
     * @param CreateRequest $request
     *
     * @return int
     */
    protected function attemptCreate(CreateRequest $request)
    {
        return Type::insertGetId($request->only([
            'name', 'introduction', 'auto_complete_hours', 'auto_complete_stars', 'real_user_auth', 'allow_user_create',
        ]));
    }
}
