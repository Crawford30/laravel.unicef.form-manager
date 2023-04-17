<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonthlyEmailReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $form;
    public $Formcount;
    public $FormUser;
    public $Formcountoday;
    public $FormUsercountoday;
    public $Formcountyesterday;
    public $FormUsercountyesterday;
    
    public function __construct($Form,$FormUser,$Formcount,$Formcountoday,$Formcountyesterday,$FormUsercountoday,$FormUsercountyesterday)
    {
        //
        $this->form = $Form;
        $this->FormUser = $FormUser;
        $this->Formcount = $Formcount;
        $this->Formcountoday = $Formcountoday;
        $this->FormUsercountoday = $FormUsercountoday;
        $this->Formcountyesterday = $Formcountyesterday;
        $this->FormUsercountyesterday = $FormUsercountyesterday;
	session(['data' => true]) ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.monthly_email_report')->subject('End of Month/Week Report');
    }
}
