<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function update(Request $request)
    {
        $name = $request->input('name');

        if (mb_strlen($name) > 64) {
            return response()->json('维修备件的长度不得超过64个字符。', 422);
        }

        if ($this->checkNameUnique($request)) {
            return response()->json('维修备件名称 已经存在。', 422);
        }

        if ($this->attemptCreate($request)) {
            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }


    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function checkNameUnique(Request $request)
    {
        return (bool)Part::whereName($request->input('name'))->whereKeyNot($request->input('id'))->first();
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function attemptCreate(Request $request)
    {
        return Part::findOrFail($request->input('id'))->forceFill($request->only('name'))->save();
    }
}
