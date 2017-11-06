<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeController extends Controller
{
    public function change(Request $request)
    {
        switch ($request->input('type')) {
            case 'accept':
                break;
            case 'finish':
                break;
            case 'delete':
                break;
            default:
                break;
        }
    }
}
