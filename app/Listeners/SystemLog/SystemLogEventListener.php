<?php

namespace App\Listeners\SystemLog;

use App\Events\SystemLog\SystemLogEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\SystemLog;
use Carbon\Carbon;

class SystemLogEventListener
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
     * @param  SystemLogEvent  $event
     * @return void
     */
    public function handle(SystemLogEvent $event)
    {
        $details = $event->data->activity; 
                
        $carbon = Carbon::now();
        $carbon->setTimezone('Asia/Manila');

        $time = $carbon->format('H:i:s');
        $date = $carbon->format("Y-m-d");

        
        $userId  = \Auth::user()->id;;
        
        
        SystemLog::create([
            'users_id' => $userId,
            'activity' => $event->data->activity,
            'activity_id' => $event->data->activity_id,
            'date' => $date,
            'time' => $time,
            'details' => $event->data->details
        ]);
    }
}
