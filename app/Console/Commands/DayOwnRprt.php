<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\DayOwnReport;
use App\EmailLog;
use App\Form;
use App\FormData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DayOwnRprt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DayOwn:Report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A Day Owner Report';

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
        
        //return email of form owner
        $FormOwnEmails = Form::Select("test_unicef_main_db.staff_profiles.email as email","form_owners.form_id")
        			->join('test_unicef_main_db.users', function($query) {
					$query->on("forms.user_id", '=', "test_unicef_main_db.users.id");
				})
				->join('test_unicef_main_db.staff_profiles', function($query) {
					$query->on("test_unicef_main_db.users.email", '=', "test_unicef_main_db.staff_profiles.email");
				}) 
				->join('form_owners', function($query) {
					$query->on("forms.user_id", '=', "form_owners.assigned_form_owner_id")
					->whereDate('form_owners.created_at', Carbon::today());
				}) 
				->get();
			
			foreach($FormOwnEmails as $FormUseEmail){
			
        try{
			
	//return count of user assigned by form owner	
         $FormUsercountoday = Form::Select("users_count")
        			->join('test_unicef_main_db.users', function($query) {
					$query->on("forms.user_id", '=', "test_unicef_main_db.users.id");
				})
				->join('test_unicef_main_db.staff_profiles', function($query) {
					$query->on("test_unicef_main_db.users.email", '=', "test_unicef_main_db.staff_profiles.email");
				}) 
				->join('form_owners', function($query) {
					//$query->on("forms.user_id", '=', "form_owners.assigned_form_owner_id")
					$query->on("forms.id", '=', "form_owners.form_id")
					->where('form_owners.form_id', '=', $FormOwnEmail->user_id)
					->whereDate('form_owners.created_at', Carbon::today());
				}) 
         	       ->distinct()
            	       ->count();
            	       		
	//return count of forms assigned by form owner	
         $Formcountoday = Form::Select("form_name")
         		->join('form_owners', function($query) {
					//$query->on("forms.user_id", '=', "form_owners.assigned_form_owner_id")
					
					$query->on("forms.id", '=', "form_owners.form_id")
					->whereDate('form_owners.created_at', Carbon::today());
				}) 
			->distinct()
            	        ->count();
            	       		
	//return count of user assigned by form owner yesterday
         $FormUsercountyesterday = Form::Select("users_count")
        			->join('test_unicef_main_db.users', function($query) {
					$query->on("forms.user_id", '=', "test_unicef_main_db.users.id");
				})
				->join('test_unicef_main_db.staff_profiles', function($query) {
					$query->on("test_unicef_main_db.users.email", '=', "test_unicef_main_db.staff_profiles.email");
				}) 
				->join('form_owners', function($query) {
					//$query->on("forms.user_id", '=', "form_owners.assigned_form_owner_id")
					$query->on("forms.id", '=', "form_owners.form_id")
					->whereDate('form_owners.created_at', Carbon::yesterday());
				}) 
         	       ->distinct()
            	       ->count();
            	       		
	//return count of forms assigned by form owner	yesterday
         $Formcountyesterday = Form::Select("form_name")
         		->join('form_owners', function($query) {
					//$query->on("forms.user_id", '=', "form_owners.assigned_form_owner_id")
					$query->on("forms.id", '=', "form_owners.form_id")
					->whereDate('form_owners.created_at', Carbon::yesterday());
				}) 
			->distinct()
            	        ->count();
	//return forms of user assigned by form owner	
         $Form = Form::Select()
         		->join('form_owners', function($query) {
					//$query->on("forms.user_id", '=', "form_owners.assigned_form_owner_id")
					$query->on("forms.id", '=', "form_owners.form_id")
					->whereDate('forms.created_at', Carbon::today())
					->whereDate('form_owners.created_at', Carbon::today());
				})
			->orderBy('form_owners.created_at', 'DESC')
            	        ->get();
            	       
        
            $mail = new DayOwnReport($Form,$Formcountoday,$FormUsercountoday,$FormUsercountyesterday,$Formcountyesterday);
            
            EmailLog::create([
                'to' =>  $FormOwnEmail->email,
                'description' => 'Daily Data Collection Report',
                'body' => $mail->render()
            ]);

            Mail::to($FormEmail->email)->send($mail);
        }catch(\Exception $ex){ print_r($ex); }
        
        }
    }
    
}
