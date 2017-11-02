<?php

namespace App\Transformers;

use App\Models\Type;
use League\Fractal\TransformerAbstract;

class TypeTransformer extends TransformerAbstract
{
    public function transform(Type $type)
    {
        return [
            'id'                  => (int)$type->id,
            'name'                => $type->name,
            'introduction'        => $type->introduction,
            'auto_complete_hours' => $type->auto_complete_hours . ' 小时',
            'auto_complete_stars' => $type->auto_complete_stars . ' 星',
            'real_user_auth'      => $type->real_user_auth ? '是' : '否',
            'allow_user_create'   => $type->allow_user_create ? '是' : '否',
        ];
    }
}
