@layout('layouts.default')


@section('title')
<title>Add New Device</title>
@endsection

@section('content')
<h3>Add New Device</h3>
{{ Form::open('create_device'); }}

{{Form::token();}}

<table>
    <tr>
        <td>{{ Form::label('name', 'Name'); }}</td>
        <td>{{ Form::text('name', Input::old('name')); }}</td>
        <td>
        @if($errors->has('name'))
        @foreach($errors->get('name', "<p class='error'>:message</p>" ) as $error)
        {{$error}}
        @endforeach
        @endif
        <td>
    </tr>

    <tr>
        <td>{{ Form::label('ip_address', 'Ip address'); }}</td>
        <td>{{ Form::url('ip_address', Input::old('ip_address', "http://")); }}</td>
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
        <td>{{ Form::number('warning_threshold', Input::old('warning_threshold', 80)); }}</td>
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
        <td>{{ Form::number('alert_threshold', Input::old('alert_threshold', 85)); }}</td>
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
        <td>{{ Form::number('critical_threshold', Input::old('critical_threshold', 90)); }}</td>
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
        <td>{{ Form::select('type', $deviceTypes, Input::old('type')); }}</td>
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
        <td>{{Form::number('ports', Input::old('ports', 1)); }}</td>
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
        <td>{{ Form::select('room_id', $rooms); }}</td>
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