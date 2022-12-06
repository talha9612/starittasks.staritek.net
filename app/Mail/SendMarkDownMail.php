<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMarkDownMail extends Mailable
{
    use Queueable, SerializesModels;
    public $task;
    public $user;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
        $this->subject($task['heading']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('markdownmail');
    }
}
