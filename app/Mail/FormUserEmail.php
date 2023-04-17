<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailLog;
    public $formName;
    public $name;
    public $fromName;
    public $email;
    public $formId;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailLog, $formName, $name, $email, $fromName, $formId)
    {


        $this->emailLog = $emailLog;
        $this->formName = $formName;
        $this->name = $name;
        $this->fromName = $fromName;
        $this->email = $email;
        $this->formId = $formId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->markdown('emails.form_manager_user')->subject('Form User Rights Assigned');
    }
}
