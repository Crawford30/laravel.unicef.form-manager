<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormOwnerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailLog;
    public $formName;
    public $name;
    public $fromName;
    public $email;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailLog,$formName, $name, $email, $fromName)
    {
        //
        $this->emailLog = $emailLog;
        $this->formName = $formName;
        $this->name = $name;
        $this->email = $email;
        $this->fromName = $fromName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.form_manager_owner')->subject('Form Owner Rights Assigned');
    }
}
