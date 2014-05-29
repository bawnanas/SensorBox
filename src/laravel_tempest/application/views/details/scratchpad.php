
@layout('layouts.default')

@section('content')
<h3>Edit Contact {{$contact->name}} </h3>
{{ Form::open('update_contact', 'POST'); }}

    {{ Form::hidden('id', $contact->id); }}


    {{ Form::label('name', 'Name'); }}
    {{ Form::text('name', Input::old('name', $contact->name)); }}

    @if($errors->has('name'))
        @foreach($errors->get('name', "<p class='error'>:message</p>" ) as $error)
            {{$error}}
        @endforeach
    @endif

    <br>

    {{ Form::label('email', 'E-mail'); }}
    {{ Form::email('email', Input::old('email', $contact->email) ); }}

    @if($errors->has('email'))
        @foreach($errors->get('email', "<p class='error'>:message</p>") as $error)
            {{$error}}
        @endforeach
    @endif

    <br>

        {{ Form::label('phone', 'Phone #'); }}
    {{ Form::telephone('phone', Input::old('phone', $contact->phone) ); }}

    @if($errors->has('phone'))
        @foreach($errors->get('phone', "<p class='error'>:message</p>") as $error)
            {{$error}}
        @endforeach
    @endif

    <br>

    {{ Form::label('carrier', 'Carrier');}}
    {{ Form::select('carrier', $carriers, Input::old('carrier', $contact->carrier)); }}

    @if($errors->has('carrier'))
        @foreach($errors->get('carrier', "<p class='error'>:message</p>") as $error)
            {{$error}}
        @endforeach
    @endif

    <br>

    {{ Form::submit('Submit'); }}

{{ Form::close(); }}
@endsection










        <table id="roomAssignments">
            <thead>
                <tr>
                    <td>Room</td>
                    <td>Contact</td>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                    <tr id={{$assignment->id}}>
                        <td class='editable'>{{$assignment->room_id}}</td>
                        <td class='editable'>{{$assignment->contact_id}}</td>
                        <td >
                        <a class="delete_link" href={{ URL::to_route('delete_assignment', array($assignment->id)); }} onclick="return confirm('are you sure you want to delete this assignment?');">remove</a>
                    </td>
                    </tr>
                @endforeach
            </tbody>

        </table>