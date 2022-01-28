@extends('common') 

@section('pagetitle')
Item List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Category List</h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('categories.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Add Category</a>
		</div>
		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table">
				<thead>
					<th>#</th>
					<th>Name</th>
					<th>Created At</th>
					<th>Last Modified</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<th>{{ $category->id }}</th>
							<td>{{ $category->name }}</td>
							<td style='width:100px;'>{{ date('M j, Y', strtotime($category->created_at)) }}</td>
							<td>{{ date('M j, Y', strtotime($category->updated_at)) }}</td>
							<td style='width:70px;'><div style='float:left; margin-right:5px;'><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success btn-sm">Edit</a></div><div style='float:left;'></div>
								{{-- Display DELETE btn only if category contains no items --}}
								{{-- bool to track whether item found in category --}}
								@php
									$itemFound = false;
								@endphp

								{{-- Iterate through items table looking for 'category_id' matching this category --}}
								@foreach ($items as $item)
									@if($item->category_id == $category->id)
										@php
											$itemFound = true;
											break;
										@endphp
									@endif
								@endforeach
								
								{{-- If no items not found in category --}}
								@if (!$itemFound)
									{{-- Display DELETE btn for category  --}}
									{!! Form::open(['route' => ['categories.destroy', $category->id], 'method'=>'DELETE']) !!}
									{{ Form::submit('Delete', ['class'=>'btn btn-sm btn-danger btn-block', 'style'=>'', 'onclick'=>'return confirm("Are you sure?")']) }}
									{!! Form::close() !!}</div>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $categories->links(); !!}
			</div>
		</div> <!-- end of .col-md-8 -->
	</div>

@endsection