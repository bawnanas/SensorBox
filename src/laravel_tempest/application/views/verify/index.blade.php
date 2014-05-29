@layout('layouts.simple')

@section('title')
<title>Verification</title>
@endsection

@section('content')

<div class="message">
	<h3>
		<?php  echo Session::get('message');  ?>
	</h3>
</div>

@if($user->email_verified == 1)
	<h3>The email address for this account has been verified!</h3>
@else
	<h3>The email address has not been verified. please click the link to send a code to that email address and then enter its code.</h3>

<a class="link"> {{HTML::link_to_route('send_code', 'Send Code', array($user->id, 'email'));}}

	<table>
		{{ Form::open('verify_user', 'POST') }}
		{{ Form::hidden('id', $user->id); }}
		{{ Form::hidden ('type', 'email'); }}
		<tr>

			<td>{{ Form::label('email_verify', 'E-mail Verification Code: ') }}</td>
			<td>{{ Form::text('email_code') }}</td>
			@if($errors->has('email_code'))
				@foreach($errors->get('email_code', "<td class='error'>:message</td>" ) as $error)
					{{$error}}
				@endforeach
			@endif
		</tr>
		<tr>
			<td>{{ Form::submit('Submit') }}</td>
		</tr>
		{{ Form::close() }}
	</table>
@endif

@if($user->phone_verified == 1)
	<h3>The phone number for this account has been verified!</h3>
@else
	<h3>The phone number has not been verified. please click the link to send a code to that phone number and then enter its code.</h3>
<a class="link"> {{HTML::link_to_route('send_code', 'Send Code', array($user->id, 'phone'));}}

	<table>
		{{ Form::open('verify_user', 'POST') }}
		{{ Form::hidden('id', $user->id); }}
		{{ Form::hidden ('type', 'phone'); }}

		<tr>
			<td>{{ Form::label('phone_verify', 'Phone Verification Code: ') }}</td>
			<td>{{ Form::text('phone_code') }}</td>
			@if($errors->has('phone_code'))
				@foreach($errors->get('phone_code', "<td class='error'>:message</td>" ) as $error)
					{{$error}}
				@endforeach
			@endif
		</tr>
	<tr>
		<td>{{ Form::submit('Submit') }}</td>
	</tr>
	{{ Form::close() }}


</table>

@endif


@endsection