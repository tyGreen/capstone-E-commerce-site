{{-- SHOPPING CART PAGE --}}

@extends('common') 

@section('pagetitle')
Shopping Cart
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
		<div class="col-md-8 col-md-offset-1">
			<h1>Your Cart</h1>
		</div>
		<div class="col-md-2">
		</div>
		<div class="col-md-12">
			<hr />
		</div>
	</div>

		{{-- ITEMS TABLE [RIGHT] --}}
		<div class="col-md-11 col-md-offset-1">
			<table class="table">
				<thead>
					<th>title</th>
					<th>quantity</th>
					<th>price</th>
					<th></th> 
					<th></th>
				</thead>
				<tbody>
					@foreach ($cartItems as $cartItem)
						<tr>
							<td>{{ $cartItem->title }}</td>
							{!! Form::model($cartItem, ['route' => ['cart.update_cart', $cartItem->item_id], 'method'=>'PUT', 'data-parsley-validate' => '']) !!}

							<td> <input type="number" name="productQuantity" min="0" value="{{  $cartItem->quantity }}"></td>
                            <td>{{ number_format($cartItem->price, 2, '.', ',') }}</td>

							<td style='width:70px;'>
                                {{-- <div style='float:left; margin-right:5px;'>
                                    <a href="{{ route('cart.update_cart', $cartItem->item_id) }}" class="btn btn-success btn-sm">Update</a>
                                </div> --}}
								{{ Form::submit('Update', ['class'=>'btn btn-sm btn-success btn-block', 'style'=>'', 'onclick'=>'return confirm("Update cart?")']) }}
							{!! Form::close() !!}
							</td style='width:70px;'>
							<td>
								<div style='float:left;'>
                                    <a href="{{ route('cart.remove_item', $cartItem->item_id) }}" class="btn btn-danger btn-sm">Remove</a>
                                </div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="col-md-12 col-md-offset-1 text-center">
				<p><b>subtotal:<b> ${{ number_format($subtotal, 2, '.', ',') }}</p>
			</div>
		</div> <!-- end of items table (right) -->

	</div>

@endsection