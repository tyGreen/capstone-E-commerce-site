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
	// If current session does not have session id & ip address set
	if(!session()->has('session_id') && !session()->has('ip_address'))
	{
		// Create new session
        // Get user's ip address & store in var
        $user_ip = Request::ip();
		
        // (Re)generate new session id
		$user_session = Session::getId();
            // $session_id = session()->getId();    ALTERNATIVE

        // Set session id and ip address to those passed into f(x)
        Session::put('session_id', $user_session);
        Session::put('ip_address', $user_ip);
	}
    
@endphp 
	
	<div class="row">
		<div class="col-md-2 col-md-offset-0">
		</div>
		<div class="col-md-8 col-md-offset-0">
			<h1>{{ $item->title }}</h1>
		</div>
		<div class="col-md-2 col-md-offset-0">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-md-offset-0">
		</div>
		<div class="col-md-8 col-md-offset-0">
			<hr />
		</div>
		<div class="col-md-2 col-md-offset-0">
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-md-offset-0">
		</div>
		{{-- Product Image (left) --}}
		<div class="col-md-3 col-md-offset-0">
			<td><img src="{{ Storage::url('images/items/'. 'lrg_' . $item->picture) }}" ></td>
		</div> 
		{{-- Product Details (right) --}}
		<div class="col-md-3 col-md-offset-0">
			<ul style="list-style: none">
				<li style="font-size: 16pt">${{ number_format($item->price, 2, '.', ',') }} </li>
				<br/>
				<li><b>Stock:</b> {{ $item->quantity }} </li>
				<li><b>Item ID:</b> {{ $item->id }} </li>
				<li><b>SKU:</b> {{ $item->sku }} </li>
			</ul>
		</div>
		<div class="col-md-3 col-md-offset-0">
		</div>
	</div> {{-- End product img/details row --}}

	{{-- Product Desc. --}}
	<div class="row">
		<div class="col-md-3 col-md-offset-0">
		</div>
		<div class="col-md-6 col-md-offset-0">
			<p style="font-size: 20pt">{!! $item->description !!} </p>
		</div>
		<div class="col-md-3 col-md-offset-0">
		</div>
	</div>

@endsection

{{-- <table class="table">
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
			<tr> --}}
				{{-- grab large (lrg_) sized img --}}
				{{-- <td><img src="{{ Storage::url('images/items/'. 'lrg_' . $item->picture) }}" ></td>
				<td>{{ $item->title }}</td>
				<td>{{ $item->id }}</td> --}}
				{{-- "enclose WYSIWYG editor text w/ { !! !!}" instead of "{{  }}" to render properly --}}
				{{-- <td>{!! $item->description !!}</td>
				<td>$ {{ number_format($item->price, 2, '.', ',') }}</td>
				<td>{{ $item->quantity }}</td>
				<td>{{ $item->sku }}</td> --}}
			{{-- </tr>
	</tbody>
</table> --}}