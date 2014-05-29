@layout('layouts.default')

@section('title')
<title>Project Tempest</title>
@endsection

@section('content')
<h3>Add New Assignment</h3>
{{ Form::open('create_assignment', 'POST'); }}

	{{Form::token();}}

<table>

	<tr class='tableform'>
    	<td>{{ Form::label('user', 'User'); }}</td>
    	<td>{{ Form::select('user_id', $users); }}</td>
    </tr>

    <tr class='tableform'>
    	<td>{{ Form::label('room_id', 'Location'); }}</td>
    	<td>{{ Form::select('room_id', $rooms); }}</td>
    </tr>
    
    <tr class='tableform'>
    	<td>{{ Form::submit('Submit'); }}</td>
    </tr>

</table>

{{ Form::close(); }}
@endsection
