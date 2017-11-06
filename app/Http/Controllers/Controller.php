<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @return int
     */
    public function id()
    {
        return (int)session('admin.id') ?: (int)session('user.id');
    }

    /**
     * @return string
     */
    public function name()
    {
        return (string)session('user.name');
    }

    /**
     * @return int
     */
    public function role()
    {
        return (int)session('admin.role');
    }

    /**
     * @return int
     */
    public function type()
    {
        return (int)session('admin.type');
    }
}
