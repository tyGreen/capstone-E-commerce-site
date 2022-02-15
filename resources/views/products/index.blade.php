{{-- PRODUCT LIST PAGE --}}

@extends('common') 

@section('pagetitle')
Product List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')

{{-- @inject('session', 'App\Http\Controllers\SessionController')
{{ $session::getData() }} --}}

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
		<div class="col-md-8 col-md-offset-1">
			<h1>Product List</h1>
		</div>
		<div class="col-md-2">
		</div>
		<div class="col-md-12">
			<hr />
		</div>
	</div>

	
	<div class="row">
		{{-- CATEGORY TABLE [LEFT] --}}
		<div class="col-md-2 col-md-offset-1">
			<table class="table">
				<thead>
					<th>Categories</th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<th><a href="{{ route('products.show', $category->id) }}">{{ $category->name }}</a></th>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> <!-- end of category table (left) -->

		{{-- ITEMS TABLE [RIGHT] --}}
		<div class="col-md-8 col-md-offset-1">
			<table class="table">
				<thead>
					<th>thumbnail</th>
					<th>title</th>
					<th>price</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($items as $item)
						<tr>
							<td>
								<a href="{{ route('products.details', $item->id) }}">
									{{-- grab thumbnail (tn_) sized img --}}
									<img src="{{ Storage::url('images/items/'. 'tn_' . $item->picture) }}" >
								</a>
							</td>
							<td>
								<a href="{{ route('products.details', $item->id) }}">
									{{ $item->title }}
								</a>
							</td>
                            <td>${{ number_format($item->price, 2, '.', ',') }}</td>

							<td style='width:70px;'>
                                <div style='float:left; margin-right:5px;'>
                                    <a href="{{ route('cart.addToCart', $item->id) }}" class="btn btn-success btn-sm" method="POST">Add To Cart</a>
                                </div>
                                <div style='float:left;'>
                                </div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{{-- Pagination buttons --}}
				{!! $items->links(); !!}
			</div>
		</div> <!-- end of items table (right) -->

	</div>

@endsection