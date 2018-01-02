<?php

namespace App\Http\Controllers\User\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RepairRequest;
use App\Models\Repair;
use App\Models\Type;
use App\Models\TypeLocationRelation;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $types = [];
        foreach (Type::whereAllowUserCreate(1)->get() as $type) {
            $locations = [];
            foreach (TypeLocationRelation::whereTypeId($type->id)->get() as $location) {
                $locations = array_merge($locations, [[
                    'id'   => $location->location->id,
                    'name' => $location->location->first . ' ' . $location->location->second,
                ]]);
            }
            $types = array_merge($types, [[
                'id'        => $type->id,
                'name'      => $type->name,
                'locations' => $locations,
            ]]);
        }

        return view('user.repair.create', ['types' => $types]);
    }

    /**
     * @param RepairRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function create(RepairRequest $request)
    {
        if (!$this->checkType($request->input('type_id'))) {
            throw ValidationException::withMessages(['fail' => '报障分类 不符合要求。']);
        }

        if (!$this->checkLocation($request->input('type_id'), $request->input('location_id'))) {
            throw ValidationException::withMessages(['fail' => '报障区域 不符合要求。']);
        }

        if ($id = $this->attemptCreate($request)) {
            return redirect()->intended('/user/repair/detail/' . $id);
        }

        throw ValidationException::withMessages(['fail' => '服务器错误。']);
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
     * @param RepairRequest $request
     *
     * @return int
     */
    protected function attemptCreate(RepairRequest $request)
    {
        $now = Carbon::now();

        $data = array_merge($request->only([
            'user_id', 'user_name', 'user_mobile', 'type_id', 'location_id', 'user_room', 'user_description',
        ]), [
            'status_id'  => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return Repair::insertGetId($data);
    }
}
