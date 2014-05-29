@layout('layouts.default')


@section('title')
<title>Edit Users</title>
@endsection



@section('content')
<h3>Edit User {{$user->username}} </h3>
{{ Form::open('update_user', 'POST'); }}
{{ Form::token(); }}

{{ Form::hidden('id', $user->id); }}


<table>

    <tr>
        <td>{{ Form::label('username', 'Name'); }}</td>
        <td>{{ Form::text('username', Input::old('username', $user->username)); }}</td>
        <td>
        @if($errors->has('username'))
        @foreach($errors->get('username', "<p class='error'>:message</p>" ) as $error)
        {{$error}}
        @endforeach
        @endif
        </td>
    </tr>

    <tr>
        <td>{{ Form::label('email', 'E-mail'); }}</td>
        <td>{{ Form::email('email', Input::old('email', $user->email) ); }}</td>
        <td>
        @if($errors->has('email'))
        @foreach($errors->get('email', "<p class='error'>:message</p>") as $error)
        {{$error}}
        @endforeach
        @endif
        </td>
    </tr>

    <tr>
        <td>{{ Form::label('phone', 'Phone #'); }}</td>
        <td>{{ Form::telephone('phone', Input::old('phone', $user->phone) ); }}</td>
        <td>
        @if($errors->has('phone'))
        @foreach($errors->get('phone', "<p class='error'>:message</p>") as $error)
        {{$error}}
        @endforeach
        @endif
        </td>
    </tr>

    <tr>
        <td>{{ Form::label('carrier', 'Carrier');}}</td>
        <td>{{ Form::select('carrier', $carriers, Input::old('carrier', $user->carrier)); }}</td>
        <td>
        @if($errors->has('carrier'))
        @foreach($errors->get('carrier', "<p class='error'>:message</p>") as $error)
        {{$error}}
        @endforeach
        @endif
        </td>
    </tr>

    <tr>
    <td>{{ Form::label('is_admin', 'is admin?'); }}</td>
        <td>{{Form::checkbox('is_admin', 1);}}</td>
    </tr>

</table>

{{ Form::submit('Submit'); }}

{{ Form::close(); }}
@endsection