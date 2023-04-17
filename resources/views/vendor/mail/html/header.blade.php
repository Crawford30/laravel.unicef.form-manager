<tr class="tr-header">
    <td class="header">
        {{--<a href="{{ $url }}">
            {{ $slot }}
        </a>

        <div style="text-align: left;">
            <div style="display: inline-block">
                <img style="height: 40px" src="{{asset("images/unicef.logo.blue.png")}}">
            </div>
        </div>--}}
        <div class="row" style="text-align: left !important;">
		 <div class="col-md-9 " >
			<div style="text-align: left;">
			    <div style="display: inline-block">
				<img style="height: 40px" src="{{asset("images/unicef.logo.blue.png")}}">
			    </div>
			</div>
		  </div>
		  <div class="col-md-3">
		  @if(session('data'))
		  <b>Monthly Data Collection Report</b><br/>
		 	<span style="text-align: right;">{{date('d/M/y',strtotime('first day of previous month'))}}</span> - 
			<span style="text-align: right;">{{date('d/M/y',strtotime('last day of previous month'))}}</span> 
		@endif
		 @if(session('data1'))
		  <b>Daily Data Collection Report</b><br/>
		 	<span style="text-align: right;">{{date('d/M/y')}}</span>
		@endif
		  </div>
        </div>
    </td>
</tr>
