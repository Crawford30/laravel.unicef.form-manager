@component('mail::message')
<div style="text-align: center;">

<span>You successfully used the following forms to collect data today</span>
<br/><br/>

<hr/><br/>

</div>
<div>
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
