{{-- COMPLETED ORDERS PAGE --}}

@extends('common') 

@section('pagetitle')
Order List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Completed Orders</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table">
				<thead>
					<th>Order #</th>
					<th>Customer Name</th>
					<th>Customer Phone</th>
					<th>Customer Email</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($orders as $order)
						<tr>
							<td><a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a></td>
							<td>{{ $order->lName . ", " . $order->fName }} </td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->email }}</td>
							<td style="width:175px;">
								<div style='float:left; margin-right:5px;'>
									<a href="{{ route('orders.show', $order->id) }}" class="btn btn-success btn-sm">View Receipt</a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $orders->links(); !!}
			</div>
		</div>
	</div>

@endsection