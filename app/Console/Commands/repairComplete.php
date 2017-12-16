<?php

namespace App\Console\Commands;

use App\Models\Repair;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class repairComplete extends Command
{
    private $key = 'repair_complete_id';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repair:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动完成报障单';

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
        if (!Cache::has($this->key)) {
            $repair = Repair::whereStatusId(3)->whereCompletedAt(null)->first();
            if (!$repair) {
                return;
            }
            Cache::forever($this->key, $repair->id);
        }

        $repair = Repair::where('id', '>=', Cache::get($this->key))->whereStatusId(3)->whereCompletedAt(null)->first();
        if ($repair) {
            $type = Type::find($repair->type_id);
            if ($repair->created_at->addHour($type->auto_complete_hours) <= Carbon::now()) {
                $repair->forceFill([
                    'user_star'    => $type->auto_complete_stars,
                    'completed_at' => $repair->created_at->addHour($type->auto_complete_hours)
                ])->save();
            }
            Cache::increment($this->key);
        } else {
            Cache::forget($this->key);
        }

        return;
    }
}
