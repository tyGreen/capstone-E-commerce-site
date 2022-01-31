@extends('common') 

@section('pagetitle')
Product Details
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
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