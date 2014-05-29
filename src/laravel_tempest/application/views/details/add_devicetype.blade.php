@layout('layouts.default')

@section('title')
<title>Add Device Type</title>
@endsection

@section('content')
<h3>Add New Device Type</h3>
{{ Form::open('create_devicetype', 'POST'); }}

{{Form::token();}}

<table>
    <tr>
        <td>{{ Form::label('name', 'New Device Type'); }}</td>
        <td>{{ Form::text('name', Input::old('name')); }}</td>
        <td>
            @if($errors->has('name'))
        @foreach($errors->get('name', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
    <td>
    </tr>
</table>
    {{ Form::submit('submit'); }}

{{ Form::close(); }}
@endsection
