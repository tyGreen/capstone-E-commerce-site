{{-- SHOPPING CART PAGE --}}

@extends('common') 

@section('pagetitle')
Shopping Cart
@endsection

@section('pagename')
Laravel Project
@endsection

@section('scripts')
{!! Html::script('/bower_components/parsleyjs/dist/parsley.min.js') !!}
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
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
		<div class="col-md-5 col-md-offset-1">
			<h1>Your Cart</h1>
		</div>
		<div class="col-md-2 col-md-offset-4">
			<a href="{{ route('products.index') }}" margin-top="5px">&lt;&lt; Back to Products</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11 col-md-offset-1">
			<hr />
		</div>
	</div>
		
		


	<div class="col-md-11 col-md-offset-1">
			<table class="table">
				<thead>
					<th>Product</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<th>Product Subtotal</th>
					<th></th> 
				</thead>
				<tbody>
					@foreach ($cartItems as $cartItem)
						<tr>
							<td>{{ $cartItem->title }}</td>
							{!! Form::model($cartItem, ['route' => ['cart.update_cart', $cartItem->item_id], 'method'=>'PUT', 'data-parsley-validate' => '']) !!}

							<td> <input type="number" name="productQuantity" min="0" value="{{  $cartItem->quantity }}"></td>
                            <td>${{ number_format($cartItem->price, 2, '.', ',') }}</td>
							<td>${{ number_format($cartItem->quantity * $cartItem->price, 2, '.', ',') }}</td>


							<td style='width:70px;'>
								{{ Form::submit('Update', ['class'=>'btn btn-sm btn-success btn-block', 'style'=>'']) }}
							{!! Form::close() !!}
								<div style='float:left;'>
									<a href="{{ route('cart.remove_item', $cartItem->item_id) }}" class="btn btn-danger btn-sm">Remove</a>
								</div>
							</td>
							{{-- <td style='width:70px;'>
								<div style='float:left;'>
                                    <a href="{{ route('cart.remove_item', $cartItem->item_id) }}" class="btn btn-danger btn-sm">Remove</a>
                                </div>
							</td> --}}
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> <!-- end of cart items table -->

		{{-- SUBTOTAL --}}
		<div class="col-md-12 col-md-offset-3 text-center">
			<p><b>Cart Subtotal:<b> ${{ number_format($subtotal, 2, '.', ',') }}</p>
		</div>

		{{-- CUSTOMER INFO FORM --}}
		<div class="col-md-4 col-md-offset-0">
		</div>
		<div class="col-md-4 col-md-offset-1">
			{!! Form::open(['route' => 'cart.check_order', 'data-parsley-validate' => '']) !!}
			    
				{{ Form::label('fName', 'First Name:') }}
			    {{ Form::text('fName', null, ['class'=>'form-control', 'style'=>'', 
			                                  'data-parsley-required'=>'',
											  'data-parsley-maxlength'=>'255']) }}

				{{ Form::label('lName', 'Last Name:') }}
				{{ Form::text('lName', null, ['class'=>'form-control', 'style'=>'', 
							  'data-parsley-required'=>'', 
							  'data-parsley-maxlength'=>'255']) }}

				{{ Form::label('phone', 'Phone:') }}
				{{ Form::text('phone', null, ['class'=>'form-control', 'style'=>'', 
							  'data-parsley-required'=>'',
							  'data-parsley-type' =>'digits',
							  'data-parsley-minlength'=>'11',
							  'data-parsley-maxlength'=>'11']) }}

				{{ Form::label('email', 'Email:') }}
				{{ Form::email('email', null, ['class'=>'form-control', 'style'=>'', 
							  'data-parsley-required'=>'', 
							  'data-parsley-maxlength'=>'255',
							  'data-parsley-type' =>'email']) }}

			    {{ Form::submit('Submit Order', ['class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top:20px']) }}

			{!! Form::close() !!}
		</div>

@endsection