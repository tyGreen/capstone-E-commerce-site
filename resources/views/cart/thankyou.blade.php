{{-- THANKYOU PAGE --}}

@extends('common') 

@section('pagetitle')
Thankyou
@endsection

@section('pagename')
Laravel Project
@endsection

{{-- If session_id not set --}}
@if(!session()->has('session_id'))
	{{-- Redirect to products page --}}
	@php
		echo "session id not set";
		return redirect()->route('products.index')->send();
	@endphp
@else
	@section('content')
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1><b>Thank You</b></h1>
				<p>Thank you for shopping with us! Your order has been received.</p>
				<h3>Receipt for order #{{ $order_id }}:</h3>
			</div>
		</div>
	
		<div class="row">
			{{-- CUSTOMER RECEIPT div --}}
			<div class="col-md-8 col-md-offset-2">
				{{-- Items Ordered --}}
				<table class="table">
					<h2>Items Ordered</h2>
					<thead>
						<th>item id</th>
						<th>item name</th>
						<th>item price</th>
						<th>item quantity</th>
					</thead>
					<tbody> 
						@foreach($items_ordered as $item)
							<tr>
								<td>{{ $item->item_id }}</td>
								<td>{{ $item->title }}</td>
								<td>{{ number_format($item->price, 2, '.', ',') }}</td>
								<td>{{ $item->quantity }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{-- Cost of Order --}}
				<div class="col-md-12 col-md-offset-0 text-center">
					<b>Cost of Order:</b> ${{ number_format($order_total,2,'.',',') }}
				</div>
				<br/>
				<br/>
				{{-- Customer Details --}}
				<table class="table">
					<h2>Customer Info</h2>
					<thead>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
						<th>Email</th>
					</thead>
					<tbody> 
						<tr>
							<td>{{ $customer_info->fName }}</td>
							<td>{{ $customer_info->lName }}</td>
							<td>{{ $customer_info->phone }}</td>
							<td>{{ $customer_info->email }}</td>
						</tr>
					</tbody>
				</table>
			</div> <!-- end CUSTOMER RECEIPT div -->
		</div>

		@php
			// Unset all session data & regenerate new session
			session()->invalidate();
			// session()->forget('session_id');
		@endphp 
	@endsection
@endif  
	