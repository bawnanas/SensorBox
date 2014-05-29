@layout('layouts.default')

@section('title')
<title>Add User</title>
@endsection

@section('content')
<h3>Add New User</h3>
{{ Form::open('create_user', 'POST'); }}

    {{Form::token();}}


<table>
    <tr>
        <td>{{ Form::label('username', 'Name:'); }}</td>
        <td>{{ Form::text('username', Input::old('username')); }}</td>
        <td>
            @if($errors->has('username'))
        @foreach($errors->get('username', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>


        <tr>
        <td>{{ Form::label('email', 'E-mail:'); }}</td>
        <td>{{ Form::email('email', Input::old('email')); }}</td>
        <td>
            @if($errors->has('email'))
        @foreach($errors->get('email', "<p class='error'>:message</p>") as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>

        <tr>
        <td>{{ Form::label('phone', 'Phone #:'); }}</td>
        <td>{{ Form::telephone('phone', Input::old('phone')); }}</td>
        <td>
            @if($errors->has('phone'))
        @foreach($errors->get('phone', "<p class='error'>:message</p>") as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>


        <tr>
        <td>{{ Form::label('carrier', 'Carrier:');}}</td>
        <td>{{ Form::select('carrier', $carriers, Input::old('carrier')); }}</td>
        <td>
                @if($errors->has('carrier'))
        @foreach($errors->get('carrier', "<p class='error'>:message</p>") as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>

        <tr>
        <td>{{ Form::label('password', 'Password:'); }}</td>
        <td>{{ Form::password('new_password'); }}</td>
        <td>
            @if($errors->has('new_password'))
        @foreach($errors->get('new_password', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif
        </td>
    </tr>

    <tr>
        <td>{{ Form::label('confirm_password', 'Confirm Password:'); }}</td>
        <td>{{ Form::password('new_password_confirmation'); }}</td>
        <td>
            @if($errors->has('new_password_confirmation'))
        @foreach($errors->get('new_password_confirmation', "<p class='error'>:message</p>" ) as $error)
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

    {{ Form::submit('submit'); }}

{{ Form::close(); }}
@endsection