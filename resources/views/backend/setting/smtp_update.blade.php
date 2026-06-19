@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Update Smtp</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Update Smtp Setting</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							
							<div class="col-lg-8">
							  <form action="{{route('update.smtp.setting')}}" method="post">
								@csrf
								<input type="hidden" name="id" value="{{$setting->id}}">
								<div class="card">
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Mailer</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="mailer" class="form-control" value="{{$setting->mailer}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Host</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="host" class="form-control" value="{{$setting->host}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Port</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="port" class="form-control" value="{{$setting->port}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">UserName</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="username" class="form-control" value="{{$setting->username}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Password</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="password" class="form-control" value="{{$setting->password}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Encryption</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="encryption" class="form-control" value="{{$setting->encryption}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">From Address</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="from_address" class="form-control" value="{{$setting->from_address}}" />
											</div>
										</div>
										
										
									
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9 text-secondary">
												<input type="submit" class="btn btn-primary px-4" value="Save Changes" />
											</div>
										</div>
									</div>
								</div>
                              </form>
							</div>
						</div>
					</div>
				</div>
			</div>

			

@endsection