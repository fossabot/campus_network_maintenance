<?php

namespace App\Http\Controllers\User\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RepairRequest;
use App\Models\Repair;
use App\Models\Type;
use App\Models\TypeLocationRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateController extends Controller
{
    public function update(RepairRequest $request)
    {
        $repair = Repair::findOrFail($request->input('id'));

        if ($repair->status_id != 1) {
            throw ValidationException::withMessages(['fail' => '当前状态无法修改。']);
        }

        if (!$this->checkType($request->input('type_id'))) {
            throw ValidationException::withMessages(['fail' => '报障分类 不符合要求。']);
        }

        if (!$this->checkLocation($request->input('type_id'), $request->input('location_id'))) {
            throw ValidationException::withMessages(['fail' => '报障地区 不符合要求。']);
        }

        if ($this->attemptUpdate($repair, $request)) {
            return redirect()->intended('/user/repair/detail/' . $request->input('id'));
        }

        throw ValidationException::withMessages(['fail' => '服务器错误。']);
    }

    public function description(Request $request)
    {
        $repair = Repair::findOrFail($request->input('id'));

        if ($repair->status_id != 1) {
            throw ValidationException::withMessages(['fail' => '当前状态无法评价。']);
        }

    }

    /**
     * @param $type_id
     *
     * @return bool
     */
    protected function checkType($type_id)
    {
        return Type::findOrFail($type_id)->allow_user_create;
    }

    /**
     * @param $type_id
     * @param $location_id
     *
     * @return bool
     */
    protected function checkLocation($type_id, $location_id)
    {
        return (bool)TypeLocationRelation::whereTypeId($type_id)->whereLocationId($location_id)->first();
    }

    /**
     * @param Model         $repair
     * @param RepairRequest $request
     *
     * @return bool
     */
    protected function attemptUpdate(Model $repair, RepairRequest $request)
    {
        return $repair->update(array_merge($request->only([
            'user_id', 'user_name', 'user_mobile', 'type_id', 'location_id', 'user_room', 'user_description',
        ]), [
            'updated_at' => Carbon::now(),
        ]));
    }

    /**
     * @param Model   $repair
     * @param Request $request
     *
     * @return bool
     */
    protected function attemptDescription(Model $repair, Request $request)
    {
        $now = Carbon::now();

        return $repair->update(array_merge($request->only([
            'user_star', 'user_evaluation',
        ]), [
            'completed_at' => $now,
            'updated_at'   => $now,
        ]));
    }
}
