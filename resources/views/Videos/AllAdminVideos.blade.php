@extends('layouts.header_footer_navbar')
@section('content')
<div class="content-body">
	<!-- row -->
	<div class="container-fluid">
		@if (Session::get('success'))
        <div class="alert alert-primary">
            {{Session::get('success')}}
        </div>
    @endif
		<div class="row page-titles mx-0">
			<div class="col-sm-6 p-md-0">
				<div class="welcome-text">
					<h4>All Videos</h4>
				</div>
			</div>
			<div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0);">Videos</a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0);">All Videos</a></li>
				</ol>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col-lg-12">
				<div class="row tab-content">
					<div id="list-view" class="tab-pane fade active show col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">All Videos  </h4>
								<a href="{{route('Add-video')}}" class="btn btn-primary">+ Add Video</a>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example3" class="display" style="min-width: 845px">
										<thead>
											<tr>
                                                <th>No</th>
                                                <th>Sheikh Name</th>
												<th>Topic</th>
												<th>Catagory</th>
												<th>Summary</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($data as $key=> $info)
											<tr>
                                                <td>{{$key+1}}</td>
												<td>{{$info->sheikh_name}}</td>
												<td>{{$info->topic}}</td>
												<td>{{$info->Catagory}}</td>
												<td style="text-align: justify">{{$info->Summary}}</td>
												<td>
													<a href="{{'Edit-Video/'.$info->id}}" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure you want to edit this Video ?')"><i class="la la-pencil"></i></a>
													<a href="{{'delete-Video/'.$info->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this Video ?')"><i class="la la-trash-o"></i></a>
												</td>												
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
	</div>
</div>

@endsection