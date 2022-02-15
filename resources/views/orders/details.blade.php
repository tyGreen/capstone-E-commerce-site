{{-- ORDER DETAILS (RECEIPT) PAGE --}}

@extends('common') 

@section('pagetitle')
Order Details
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1><b>Order Details:</b> order <i>#{{ $order_customer->id }}</i></h1>
		</div>
	</div>

	<div class="row">
        {{-- CUSTOMER RECEIPT div --}}
		<div class="col-md-8 col-md-offset-2">
            {{-- Items Ordered --}}
			<table class="table">
                <h2>Items Ordered</h2>
				<thead>
					<th>Item ID</th>
					<th>Item</th>
					<th>Unit Price</th>
					<th>Item Subtotal</th>
                    <th>Item Quantity</th>
				</thead>
				<tbody> 
                    @foreach($item_details as $item_detail)
						<tr>
							<td>{{ $item_detail->item_id }}</td>
							<td>{{ $item_detail->name }}</td>
                            <td>${{ number_format($item_detail->price, 2, '.', ',') }}</td>
							<td>${{ number_format($item_detail->quantity * $item_detail->price, 2, '.', ',') }}</td>
                            <td>{{ $item_detail->quantity }}</td>
						</tr>
                    @endforeach
				</tbody>
			</table>
            {{-- Cost of Order --}}
            <div class="col-md-12 col-md-offset-0 text-center">
                <b>Order Total:</b> ${{ number_format($orderTotal,2,'.',',') }}
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
                        <td>{{ $order_customer->fName }}</td>
                        <td>{{ $order_customer->lName }}</td>
                        <td>{{ $order_customer->phone }}</td>
                        <td>{{ $order_customer->email }}</td>
                    </tr>
				</tbody>
			</table>
		</div> <!-- end CUSTOMER RECEIPT div -->
	</div>

@endsection