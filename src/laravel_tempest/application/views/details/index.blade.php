@layout('layouts.default')

@section('title')
<title>System Details</title>
@endsection


@section('include')
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src = "js/edit.js"></script>
@endsection

@section('glance')
<div id="tabs">
	<ul>
		<li class="headerbar"><a href="#roomsTab">Rooms</a></li>
		<li class="headerbar"><a href="#devicesTab">Devices</a></li>
		<li class="headerbar"><a href="#usersTab">Users</a></li>
		<li class="headerbar"><a href="#assignmentsTab">Assignments</a></li>
		<li class="headerbar"><a href="#typesTab">Device Types</a></li>
	</ul>
</div>
@endsection


@section('content')


{{Form::token()}}

<div id = "roomsTab">
	<h2>Rooms</h2>
	<table id="roomsTable">
		<thead>
			<tr>
				<td>ID</td>
				<td>Name</td>
			</tr>
		</thead>

		<tbody>
				@foreach($rooms as $room)
				<tr class="{{e($room->name)}}" id={{$room->id}}>	
					<td>{{$room->id}}</td>
					<td class='editable'>{{e($room->name)}}</td>
					@if(Auth::user()->is_admin)
					<td >
						<a class="edit_link"> {{HTML::link_to_route('edit_room', 'edit', array($room->id));}}
					</td>
					<td >
					<a class='delete_link' href={{ URL::to_route('delete_room', array($room->id)); }} onclick="return confirm('Do You Really Want to remove this room? (all devices and associated data will be lost permanently)');">remove</a>
					</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>

		@if(Auth::user()->is_admin)
		<p> {{HTML::link_to_route('add_room', 'Add Room');}} </p>
		@endif

	</div>


	<div id = "devicesTab">
		<h2>Devices</h2>
		<table id="devicesTable">
			<thead>
				<tr>
					<td>ID</td>
					<td>Name</td>
					<td>Location</td>
					<td>IP Address</td>
					<td>Type</td>
					<td>Ports</td>
					<td>Warning</td>
					<td>Alert</td>
					<td>Critical</td>
					<td>Status</td>
				</tr>
			</thead>
			
			<tbody>
				@foreach($devices as $device)
				<tr id={{$device->id}}>	
					<td>{{$device->id}}</td>
					<td class='editable'>{{e($device->name)}}</td>
					<td class='editable'>{{e($device->room_id)}}</td>
					<td class='editable'>{{e($device->ip_address)}}</td>
					<td class='editable'>{{e($device->type)}}</td>
					<td class='editable'>{{e($device->ports)}}</td>
					<td class='editable'>{{e($device->warning_threshold)}}</td>
					<td class='editable'>{{e($device->alert_threshold)}}</td>
					<td class='editable'>{{e($device->critical_threshold)}}</td>
					<td >{{$device->status}}</td>
					@if(Auth::user()->is_admin)
					<td >
						<a class="edit_link"> {{HTML::link_to_route('edit_device', 'edit', array($device->id));}}</a>
					</td>
					<td >
						<a class='delete_link' href={{ URL::to_route('delete_device', array($device->id)); }} onclick="return confirm('Do You Really Want to remove this room? (all devices and associated data will be lost permanently)');">remove</a>
					</td>
					@endif
					@endforeach
				</tbody>
			</table>

			@if(Auth::user()->is_admin)
			<p> {{HTML::link_to_route('add_device', 'Add Device')}} </p>
			@endif
		</div>

		<div id="usersTab">
			<h2>Users</h2>
			<table id="usersTable">
				<thead>
					<tr>
						<td>ID</td>
						<td>Name</td>
						<td>E-mail</td>
						<td>Verified</td>
						<td>Phone</td>
						<td>Verified</td>
						<td>Carrier</td>
						<td>Admin</td>
					</tr>
				</thead>

				<tbody>
					@foreach($users as $user)
					<tr id={{e($user->id)}}>
						<td>{{e($user->id)}}</td>	
						<td class='editable'>{{e($user->username)}}</td>
						<td class='editable'>{{e($user->email)}}</td>
						
						@if($user->email_verified == 1)
							<td>yes</td>
						@else
							<td>no</td>
						@endif

						<td class='editable'>{{e($user->phone)}}</td>

						@if($user->phone_verified == 1)
							<td>yes</td>
						@else
							<td>no</td>
						@endif

						<td class='editable'>{{e($user->carrier)}}</td>

						@if($user->is_admin == 1)
							<td>yes</td>
						@else
							<td>no</td>
						@endif

						@if(Auth::user()->is_admin)
						<td >
							<a class="verify_link"> {{HTML::link_to_route('verify_user', 'verify', array($user->id));}}</a>
						</td>

						<td >
							<a class="edit_link"> {{HTML::link_to_route('edit_user', 'edit', array($user->id));}}</a>
						</td>
						<td >
							<a class='delete_link' href={{ URL::to_route('delete_user', array($user->id)); }} onclick="return confirm('are you sure you want to delete this user? (all associated assignments will be deleted.)');">remove</a>
					</td>
					@endif
					</tr>
					@endforeach
				</tbody>
			</table>

			@if(Auth::user()->is_admin)
			<p> {{HTML::link_to_route('add_user', 'Add user')}} </p>
			@endif
		</div>

		<div id="assignmentsTab">
		<h2>Room Assignments</h2>
		<table id="roomAssignments">

		@foreach ($rooms as $room)
			<thead>
				<td>{{e($room->name)}}</td>
			<thead>

			@foreach($assignments as $assignment)
				<tbody>
						@if($assignment->room_id == $room->id)
							@foreach($users as $user)
								@if($user->id == $assignment->user_id)
                        		<tr>
                        			<td>{{e($user->username)}}</td>
                        			@if(Auth::user()->is_admin)
                        		<td><a class="delete_link" href={{ URL::to_route('delete_assignment', array($assignment->id)); }} onclick="return confirm('are you sure you want to delete this assignment?');">remove</a>
								</td>
								@endif
								</tr>
								@endif
							@endforeach
						@endif
				</tbody>
			@endforeach

		@endforeach
		</table>

		@if(Auth::user()->is_admin)
		<p> {{HTML::link_to_route('add_assignment', 'Add Assignment')}}</p>
		@endif

		</div>


	<div id = "typesTab">
	<h2>Device Types</h2>
	<table id="typesTable" >
		<thead>
			<tr>
				<td>ID</td>
				<td>Name</td>
			</tr>
		</thead>


		<tbody>
				@foreach($deviceTypes as $type)
				<tr class={{e($type->name)}} id={{e($type->id)}}>	
					<td>{{$type->id}}</td>
					<td class='editable'>{{$type->name}}</td>
					<td>
					@if(Auth::user()->is_admin)
						<a href={{ URL::to_route('delete_devicetype', array($type->id)); }} onclick="return confirm('are you sure you want to delete this device type? (Please verify no other devices are using it.)');">remove</a>
					</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>

		@if(Auth::user()->is_admin)
		<p> {{HTML::link_to_route('add_devicetype', 'Add Device Type')}} </p>
		@endif
	</div>

@endsection