@layout('layouts.default')

@section('title')
<title>Tempest</title>
@endsection


@section('include')
	<script src="{{ URL::to_asset("js/jquery-1.9.1.min.js") }}"></script>
	<script src="{{ URL::to_asset("js/highstock.js") }}"></script>

	<script src="{{ URL::to_asset("js/themes/gray.js") }}"></script>
	<script src="{{ URL::to_asset("js/mygraph.js") }}"></script>

	<script src="{{ URL::to_asset("js/GraphRoom.js") }}"></script>
	<script src="{{ URL::to_asset("js/GraphDeltas.js") }}"></script>



@endsection


@section('content')

	<h3>click on a room name to view its graph</h3>
	<h3>click on a port number to view its daily highs and lows</h3>
	<div class = "graphs" id="temperatures_over_time"></div>
@endsection


@section('glance')

	@foreach($rooms as $room)
		<h3 class=headerbar id={{$room->name}}>{{$room->name}}</h3>
		<table class="deviceGlance">
			@foreach($devices as $device)
				
				@if($room->id == $device->room_id)
					<tr>
						<td class= "{{$device->status}}" >
						@if ($device->status === "OK")
							{{HTML::image("img/veryicon.com/Matt_Ball/png/GreenBall.png", "OK", array('id' => 'ok'));}}
						@elseif ($device->status === "WARNING")
							{{HTML::image("img/veryicon.com/Matt_Ball/png/YellowBall.png", "WARNING", array('id' => 'warning'));}}
						@elseif ($device-> status === "ALERT")
							{{HTML::image("img/veryicon.com/Matt_Ball/png/RedBall.png", "ALERT", array('id' => 'alert'));}}
						@elseif ($device-> status === "CRITICAL")
							{{HTML::image("img/veryicon.com/Matt_Ball/png/RedBall.png", "CRITICAL", array('id' => 'critical'));}}
						@elseif ($device-> status === "C_N_C")
							{{HTML::image("img/veryicon.com/Matt_Ball/png/MrBomb.png", "C_N_C", array('id' => 'c_n_c'));}}
						@endif
						</td>
						<td>{{$device->name}}</td>
					</tr>

					@for( $i = 0; $i < sizeof($deltas) ; $i++ ) 
						@if($deltas[$i]->device_id == $device->id)
						<tr>
							<td class=port id="{{$device->id}} {{$deltas[$i]->port}}">{{$deltas[$i]->port}}</td>
							<td> {{$deltas[$i]->close}}</td>
						</tr>
						@endif 
					@endfor


				@endif

			@endforeach
		</table>
	@endforeach
@endsection