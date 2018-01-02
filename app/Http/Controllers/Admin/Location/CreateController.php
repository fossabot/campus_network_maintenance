<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationRequest;
use App\Models\Location;

class CreateController extends Controller
{
    /**
     * 创建维修区域
     *
     * @param LocationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(LocationRequest $request)
    {
        // 分辨创建一级区域还是二级区域
        $flag = (bool)$request->input('second');

        if (!$flag) {
            // 创建一级区域
            if ($this->checkFirstUnique($request->input('first'))) {
                return response()->json('一级区域 已经存在。', 422);
            }

            if ($id = $this->attemptCreateFirst($request)) {
                return response()->json($id);
            }
        } else {
            // 创建二级区域
            if (!$this->checkFirstUnique($request->input('first'))) {
                return response()->json('一级区域 不存在。', 422);
            }

            if ($this->checkSecondUnique($request->input('first'), $request->input('second'))) {
                return response()->json('二级区域 已经存在。', 422);
            }

            if ($id = $this->attemptCreateSecond($request)) {
                return response()->json($id);
            }
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param $first
     *
     * @return bool
     */
    protected function checkFirstUnique($first)
    {
        return (bool)Location::whereFirst($first)->first();
    }

    /**
     * @param $first
     * @param $second
     *
     * @return bool
     */
    protected function checkSecondUnique($first, $second)
    {
        return (bool)Location::whereFirst($first)->whereSecond($second)->first();
    }

    /**
     * @param LocationRequest $request
     *
     * @return int
     */
    protected function attemptCreateFirst(LocationRequest $request)
    {
        return Location::insertGetId($request->only(['first']));
    }

    /**
     * @param LocationRequest $request
     *
     * @return int
     */
    protected function attemptCreateSecond(LocationRequest $request)
    {
        return Location::insertGetId($request->only(['first', 'second']));
    }
}
