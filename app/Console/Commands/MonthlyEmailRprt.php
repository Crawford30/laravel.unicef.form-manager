<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\MonthlyEmailReport;
use App\EmailLog;
use App\Form;
use App\FormData;
use Carbon\Carbon;
use App\StaffProfile;
use Illuminate\Support\Facades\Mail;

class MonthlyEmailRprt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MonthlyEmail:Report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Email Report';

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
        
         $Formcount = Form::Select("form_name")->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth()->toDateString(),Carbon::now()->subMonth()->endOfMonth()->toDateString(),])->distinct()
            	       ->count();
         
        
	//return count of user assigned by form owner	
         $FormUsercountoday = Form::Select("users_count")
					->whereDate('created_at', Carbon::today())
			 	       ->distinct()
			    	       ->count();
            	       		
	//return count of forms today	
            	       
         $Formcountoday = Form::Select("form_name")->whereDate('created_at', Carbon::today())
			 		->distinct()
			    	       ->count();
			    	       		
	//return count of user assigned by form owner yesterday
         $FormUsercountyesterday = Form::Select("users_count")
					->whereDate('created_at', Carbon::yesterday())
			 	       ->distinct()
			    	       ->count();
            	       		
	//return count of forms assigned by form owner	yesterday
         $Formcountyesterday = Form::Select("form_name")
					->whereDate('created_at', Carbon::yesterday())
					->distinct()
			    	        ->count();
			    	        
         $Form = Form::Select()->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth()->toDateString(),Carbon::now()->subMonth()->endOfMonth()->toDateString()])
         		->orderBy('created_at', 'DESC')
            	       ->get();
            	       
            	       $FormUser = Form::Select("test_unicef_main_db.staff_profiles.personal_id as personal_id","test_unicef_main_db.staff_profiles.name as name","test_unicef_main_db.staff_profiles.position_text as position","is_completed")->join('test_unicef_main_db.users', function($query) {
					$query->on("forms.user_id", '=', "test_unicef_main_db.users.id");
				}) ->join('test_unicef_main_db.staff_profiles', function($query) {
					$query->on("test_unicef_main_db.users.email", '=', "test_unicef_main_db.staff_profiles.email")
					->whereBetween('forms.created_at', [Carbon::now()->subMonth()->startOfMonth()->toDateString(),Carbon::now()->subMonth()->endOfMonth()->toDateString(),]);
				}) 
            	       		->limit(5)
            	       		->get();
            	       
            $mail = new MonthlyEmailReport($Form,$FormUser,$Formcount,$Formcountoday,$Formcountyesterday,$FormUsercountoday,$FormUsercountyesterday);
            
            
            //send mail to info@trailanalytics.com
            try{
            
            EmailLog::create([
                'to' =>  'info@trailanalytics.com',
                'description' => 'End of Month/Week Report',
                'body' => $mail->render()
            ]);

            Mail::to('info@trailanalytics.com')->send($mail);
            
             }catch(\Exception $ex){ print_r($ex); }
             
            //send mail to tech@trailanalytics.com
            try{
            
            EmailLog::create([
                'to' =>  'tech@trailanalytics.com',
                'description' => 'End of Month/Week Report',
                'body' => $mail->render()
            ]);

            Mail::to('tech@trailanalytics.com')->send($mail);
            
             }catch(\Exception $ex){ print_r($ex); }
             
            
            //send mail to all staff in planning,monitoring and data analytics
            try{
            $staff = StaffProfile::whereNotNull("email")
                                ->where("section", "=", "16")
                                ->orderBy("name", "asc")->get();
                                
                 foreach($staff as $staffplann){               
                 
            EmailLog::create([
                'to' =>  $staffplann->email,
                'description' => 'End of Month/Week Report',
                'body' => $mail->render()
            ]);

            //Mail::to($staffplann->email)->send($mail);
            
            }
            
            
        }catch(\Exception $ex){ print_r($ex); }
    
    }
}
