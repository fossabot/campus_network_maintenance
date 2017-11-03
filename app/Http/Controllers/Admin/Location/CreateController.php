<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationRequest;
use App\Models\Location;

class CreateController extends Controller
{
    public function create(LocationRequest $request)
    {
        $flag = (bool)$request->input('second');

        if (!$flag) {
            // 创建主要地区
            if ($this->checkFirstUnique($request->input('first'))) {
                return response()->json('主要地区 已经存在。', 422);
            }

            if ($id = $this->attemptCreateFirst($request)) {
                return response()->json($id, 200);
            }
        } else {
            // 创建次要地区
            if (!$this->checkFirstUnique($request->input('first'))) {
                return response()->json('主要地区 不存在。', 422);
            }

            if ($this->checkSecondUnique($request->input('first'), $request->input('second'))) {
                return response()->json('次要地区 已经存在。', 422);
            }

            if ($id = $this->attemptCreateSecond($request)) {
                return response()->json($id, 200);
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
