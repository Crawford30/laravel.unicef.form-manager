@component('mail::message')
<div style="text-align: center;">

<span><b>{{$Formcount}} Records</b></span><br/><br/>
<span>were collected using the data collection forms this past month. Details are provided below</span><br/><br/>

<div class="row">
				<div class="col-md-4">

				   <div  style="width: 100%;height:100%; color:white" class="btn btn-success mb-1" >
				        <h1 style="text-align: center;font-size:30px !important;color: white !important;font-weight: 400;">{{$Formcountoday}}</h1>
				    	<span style="font-size:100%;color:white !important;margin-bottom: 0;padding-bottom: 0;">Forms were used today @if($FormUsercountyesterday !== 0){{$Formcountoday / $Formcountyesterday * 100}} % @else {{$Formcountoday}}% @endif than yesterday</span>
				   </div>
				</div>	
				<div class="col-md-4">
				    <div  style="width: 100%;height:100%;" class="btn btn-primary mb-1">
				        <h1 style="text-align: center;font-size:30px !important;color: white !important;font-weight: 400;">{{$FormUsercountoday}}</h1>
				    	<span style="font-size: 100%;color: white !important;margin-bottom: 0;padding-bottom: 0;"> Users collected data @if($FormUsercountyesterday !== 0){{$FormUsercountoday / $FormUsercountyesterday * 100}} % @else {{$FormUsercountoday}}% @endif than yesterday</span>
				    </div>
				</div>	
				<div class="col-md-4">
				    <div  style="width: 100%; background-color: #BA55D3;height:100%;color:white" class="btn mb-1">
				    <h1 style="text-align: center;font-size:30px !important;color: white !important;font-weight: 400;">{{$Formcountoday}} Records/Day</h1>
				    	<span style="font-size: 100%;color:white !important;margin-bottom: 0;padding-bottom: 0;">  was the avg data collection rate same as the previous month</span>
				    </div>
				</div>
				
</div>				
</div>	


<hr/><br/>

<table class="table unicef-table-header mb-3 mt-3">
		    <thead>
			<tr>
                            <th>FORM NAME</th>
                            <th>LAST RECORD RECEIVED</th>
                            <th>CHANNEL</th>
                            <th>DATA</th>
                            <th>CHANGES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($form as $forms)
                        <tr>
                            <td>
                               {{ $forms->form_name }}
                            </td>
                            <td style="text-align: center;">
                               {{ date('H:m',strtotime($forms->created_at)) }} H
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->is_completed }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->data_count }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->fields_count }}
                            </td>
                        </tr>
                     @endforeach
                        
                    </tbody>
</table>
<hr/><br/>

<div style="text-align: center;">
<p>Here are some additional statistics on the top 5 users who collected data this past month</p>

</div>

<div>
<br/><br/>
<table class="table unicef-table-header mb-3 mt-3">
		    <thead>
			<tr>
                            <th>PERSONNEL ID</th>
                            <th>NAMES</th>
                            <th>POSITION</th>
                            <th>CHANNEL</th>
                            <th>DATA</th>
                            <th>CHANGES</th>
                        </tr>
                    </thead>
                    <tbody>@foreach ($FormUser as $forms)
                        <tr>
                            <td>
                               {{ $forms->personal_id }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->name }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->position }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->is_completed }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->data_count }}
                            </td>
                            <td style="text-align: center;">
                               {{ $forms->fields_count }}
                            </td>
                        </tr>
                     @endforeach
                        
                    </tbody>
</table>
</div>
@endcomponent
