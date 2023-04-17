<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\DayUseReport;
use App\EmailLog;
use App\Form;
use App\FormData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DayUseRprt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DayUse:Report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A Day User Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
       
        
				
            	       		// return user assigned form email for mail sending
        $FormUseEmails = Form::Select("test_unicef_main_db.staff_profiles.email as email","forms.user_id as user_id")
        			->join('test_unicef_main_db.users', function($query) {
					$query->on("forms.user_id", '=', "test_unicef_main_db.users.id");
				})
				->join('test_unicef_main_db.staff_profiles', function($query) {
					$query->on("test_unicef_main_db.users.email", '=', "test_unicef_main_db.staff_profiles.email");
				}) 
				->join('form_users', function($query) {
					$query->on("forms.user_id", '=', "form_users.assigned_user_id")
					->whereDate('form_users.created_at', Carbon::today());
				}) 
				->get();
            	       		
            	       		
            	       foreach($FormUseEmails as $FormUseEmail){
            	       
            	       try{ 
            	       // return user assigned form data for mail sending
        $Form = Form::Select()->join('test_unicef_main_db.users', function($query) {
					$query->on("forms.user_id", '=', "test_unicef_main_db.users.id");
				})
				->join('test_unicef_main_db.staff_profiles', function($query) {
					$query->on("test_unicef_main_db.users.email", '=', "test_unicef_main_db.staff_profiles.email");
				}) 
				->join('form_users', function($query) {
					//$query->on("forms.user_id", '=', "form_users.assigned_user_id")
					$query->on("forms.id", '=', "form_users.form_id")
					->where('forms.user_id', '=', $FormUseEmail->user_id)
					->whereDate('forms.created_at', Carbon::today())
					->whereDate('form_users.created_at', Carbon::today());
				}) 
				->get();
				
				    $mail = new DayUseReport($Form);
				    EmailLog::create([
					'to' =>  $FormUseEmail->email,
					'description' => 'Daily Data Collection Report',
					'body' => $mail->render()
				    ]);

				    Mail::to($FormEmail->email)->send($mail);
				}catch(\Exception $ex){ print_r($ex); }
				
			}
    }
}
