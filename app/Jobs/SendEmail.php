<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\SendMarkDownMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $task;
    public $user;
   
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendMarkDownMail($this->task, $this->user);
        Mail::to($this->user['email'])->send($email);
    }
}
