<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class adminCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建超级管理员账户';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Admin::whereUsername($this->argument('username'))->first()) {
            $this->warn('管理员帐号 已经存在。');
            return;
        }

        $id = Admin::insertGetId([
            'role_id'    => 9,
            'type_id'    => 0,
            'username'   => $this->argument('username'),
            'password'   => Hash::make($this->argument('password')),
            'name'       => $this->argument('username'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($id > 0) {
            $this->info('创建成功！');
        } else {
            $this->error('服务器错误');
        }

        return;
    }
}
