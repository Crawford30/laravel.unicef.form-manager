@component('mail::message')
<div style="text-align: center;">

<span>The following forms were used to collect data today</span>
<br/><br/>
<div class="row">
				<div class="col-md-6">
				   <div  style="width: 100%;height:100%" class="btn btn-success mb-1" >
				        <h1 style="text-align: center;font-size:30px !important;color: white !important;font-weight: 400;">{{$Formcountoday}}</h1>
				    	<span style="font-size: 100%;color: white !important;margin-bottom: 0;padding-bottom: 0;">Forms were used today @if($FormUsercountyesterday !== 0) {{$Formcountoday / $Formcountyesterday  * 100}} % @else {{$Formcountoday}}% @endif than yesterday</span>
				   </div>
				</div>	
				<div class="col-md-6">
				    <div  style="width: 100%;height:100%" class="btn btn-primary mb-1">
				        <h1 style="text-align: center;font-size:30px !important;color: white !important;font-weight: 400;">{{$FormUsercountoday}}</h1>
				    	<span style="font-size: 100%;color: white !important;margin-bottom: 0;padding-bottom: 0;"> Users collected data @if($FormUsercountyesterday !== 0) {{$FormUsercountoday/$FormUsercountyesterday * 100}} % @else {{$FormUsercountoday}}% @endif than yesterday</span>
				    </div>
				</div>
				
</div>	
</div>
<div>
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
</div>
@endcomponent
