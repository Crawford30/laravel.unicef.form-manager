<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailLog;
    public $name;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param $emailLog
     * @param $name
     * @param $email
     * @param $password
     */
    public function __construct($emailLog, $name, $email, $password)
    {
        $this->emailLog = $emailLog;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.account_created');
    }
}

