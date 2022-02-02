@extends('common') 

@section('pagetitle')
Product Details
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')

@php
// GET current session data
	// If current session has session id & ip address set
	if(Session::has('session_id') && Session::has('ip_address'))
	{
		// Echo id & ip to screen
		echo "session_id: " . Session::get('session_id');
		echo "<br/>";
		echo "ip_address: " . Session::get('ip_address');
	}
	else
	{
		// Otherwise, create new session
        // Get user's ip address & store in var
        $user_ip = Request::ip();
		
        // Get current session id & store in var
        $user_session = Session::getId();
            // $session_id = session()->getId();    ALTERNATIVE

        // Set session id and ip address to those passed into f(x)
        Session::put('session_id', $user_session);
        Session::put('ip_address', $user_ip);
	}      
@endphp 
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>{{ $item->title }}</h1>
		</div>
		<div class="col-md-2">
		</div>
		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table">
				<thead>
					<th>picture</th>
					<th>title</th>
					<th>id</th>
                    <th>desc</th>
                    <th>price</th>
                    <th>quantity</th>
                    <th>sku</th>
				</thead>
				<tbody>
						<tr>
							{{-- grab large (lrg_) sized img --}}
							<td><img src="{{ Storage::url('images/items/'. 'lrg_' . $item->picture) }}" ></td>
							<td>{{ $item->title }}</td>
							<td>{{ $item->id }}</td>
							{{-- "enclose WYSIWYG editor text w/ { !! !!}" instead of "{{  }}" to render properly --}}
                            <td>{!! $item->description !!}</td>
                            <td>{{ number_format($item->price, 2, '.', ',') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->sku }}</td>
						</tr>
				</tbody>
			</table>
		</div> <!-- end of .col-md-8 -->
	</div>

@endsection