<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Task;
use App\User;
use App\Mail\TaskDueReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class Kernel extends ConsoleKernel
{
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         $now = Carbon::now();
    //         $tasks = Task::whereBetween('due_date', [$now->toDateString(), $now->copy()->addDays(1)->toDateString()])->get();

    //         Log::info('Tasks to be processed for email:', $tasks->toArray());

    //         foreach ($tasks as $task) {
    //             if ($task instanceof \App\Task) { // Ensure it is an instance of the Task model
    //                 $creatorEmail = optional(User::find($task->created_by))->email;
    //                 $assigneeEmail = optional(User::find($task->user_id))->email;

    //                 if ($creatorEmail && $assigneeEmail) {
    //                     Mail::to($creatorEmail)
    //                         ->cc($assigneeEmail)
    //                         ->send(new TaskDueReminder($task));
    //                 } else {
    //                     Log::warning('Task missing email addresses:', ['task' => $task->toArray()]);
    //                 }
    //             } else {
    //                 Log::error('Unexpected object type:', ['task' => $task]);
    //             }
    //         }
    //     })->everyMinute(); // Adjust for testing
    // }
    // app/Console/Kernel.php

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $now = Carbon::now();
            $tasks = Task::with(['creator', 'assignee'])
                ->whereBetween('due_date', [$now->toDateString(), $now->copy()->addDays(2)->toDateString()])
                ->get();

            foreach ($tasks as $task) {
                if ($task->creator && $task->assignee) {
                    Mail::to($task->creator->email)
                        ->cc($task->assignee->email)
                        ->send(new TaskDueReminder($task));
                } else {
                    Log::warning('Task missing user data:', ['task' => $task->toArray()]);
                }
            }
        })->daily(); // Adjust as needed
    }



    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
