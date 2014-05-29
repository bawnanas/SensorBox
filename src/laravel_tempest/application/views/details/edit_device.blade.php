@layout('layouts.default')


@section('title')
<title>Edit Device</title>
@endsection



@section('content')
<h3>Edit Device {{$device->name}} </h3>
{{ Form::open('update_device', 'POST'); }}
{{Form::token();}}
{{ Form::hidden('id', $device->id); }}



<table>
    <tr>
        <td> {{ Form::label('name', 'Name'); }}</td>
        <td>{{ Form::text('name', $device->name); }}</td>
        <td>
            @if($errors->has('name'))
        @foreach($errors->get('name', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>


        <tr>
        <td>{{ Form::label('ip_address', 'Ip address'); }}</td>
        <td>{{ Form::text('ip_address', $device->ip_address); }}</td>
        <td>
                    @if($errors->has('ip_address'))
        @foreach($errors->get('ip_address', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>

        <tr>
        <td>{{ Form::label('warning', 'Warning Threshold'); }}</td>
        <td>{{ Form::number('warning_threshold', $device->warning_threshold); }}</td>
        <td>
        @if($errors->has('warning_threshold'))
        @foreach($errors->get('warning_threshold', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>


        <tr>
        <td>{{ Form::label('alert', 'Alert Threshold'); }}</td>
        <td>{{ Form::number('alert_threshold', $device->alert_threshold); }}</td>
        <td>
               @if($errors->has('alert_threshold'))
        @foreach($errors->get('alert_threshold', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>

        <tr>
        <td>{{ Form::label('critical', 'Critical Threshold'); }}</td>
        <td>{{ Form::number('critical_threshold', $device->critical_threshold); }}</td>
        <td>
                @if($errors->has('critical_threshold'))
        @foreach($errors->get('critical_threshold', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>
        <tr>
        <td>{{ Form::label('type', 'Type'); }}</td>
        <td>{{ Form::select('type', $deviceTypes, $device->type); }}</td>
        <td>
                @if($errors->has('type'))
        @foreach($errors->get('type', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>

    </tr>

        <tr>
        <td>{{Form::label('ports', 'Ports'); }}</td>
        <td>{{Form::number('ports', $device->ports); }}</td>
        <td>
                @if($errors->has('ports'))
        @foreach($errors->get('ports', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>
        <tr>
        <td>{{ Form::label('room_id', 'Location'); }}</td>
        <td>{{ Form::select('room_id', $rooms, $device->room_id); }}</td>
        <td>
               @if($errors->has('alert_threshold'))
        @foreach($errors->get('alert_threshold', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>
</table>
    {{ Form::submit('Submit'); }}

{{ Form::close(); }}
@endsection