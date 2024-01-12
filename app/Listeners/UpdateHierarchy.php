<?php

namespace App\Listeners;

use App\Events\HierarchyChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateHierarchy
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\HierarchyChange  $event
     * @return void
     */
    public function handle(HierarchyChange $event)
    {
        if($event->modelId == null){
            DB::table($event->table)
                ->where('hierarchy', '>=', $event->hierarchy)
                ->update(['hierarchy' => DB::raw('hierarchy + 1')]);
        }else{
            DB::table('images')
                ->where('hierarchy', '>=', $event->hierarchy)
                ->where('model_id', '=', $event->modelId)
                ->where('model_type', '=', $event->table)
                ->update(['hierarchy' => DB::raw('hierarchy + 1')]);
        }
    }
}
