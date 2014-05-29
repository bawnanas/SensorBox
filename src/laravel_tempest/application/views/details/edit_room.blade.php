@layout('layouts.default')


@section('title')
<title>Edit Room</title>
@endsection



@section('content')
<h3>Edit Room {{$room->name}} </h3>
{{ Form::open('update_room', 'POST'); }}

{{Form::token();}}

	{{ Form::hidden('id', $room->id); }}

	

	<table>
	<tr>
        <td>{{ Form::label('name', 'Name:'); }}</td>
        <td>{{ Form::text('name', Input::old('name', $room->name)); }}</td>
        <td>
            @if($errors->has('name'))
                @foreach($errors->get('name', "<p class='error'>:message</p>" ) as $error)
                    {{$error}}
                @endforeach
            @endif
        </td>
    </tr>
    </table>

        {{ Form::submit('submit'); }}

{{ Form::close(); }}
@endsection
