<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DayOwnReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $form;
    public $Formcountoday;
    public $FormUsercountoday;
    public $FormUsercountyesterday;
    public $Formcountyesterday;
    
    public function __construct($Form,$Formcountoday,$FormUsercountoday,$FormUsercountyesterday,$Formcountyesterday)
    {
        //
        $this->form = $Form;
        $this->Formcountoday = $Formcountoday;
        $this->FormUsercountoday = $FormUsercountoday;
        $this->FormUsercountyesterday = $FormUsercountyesterday;
        $this->Formcountyesterday = $Formcountyesterday;
	session(['data1' => true]) ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.day_owner_report')->subject('Daily Data Collection Report');
    }
}
