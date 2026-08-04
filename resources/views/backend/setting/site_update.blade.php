@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Update Site Setting</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Update Site Setting</li>
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
							  <form action="{{route('update.site.setting')}}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value="{{$siteSetting->id}}">
								<div class="card">
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Company Phone</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="company_phone" class="form-control" value="{{$siteSetting->company_phone}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Company Address</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="company_address" class="form-control" value="{{$siteSetting->company_address}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="email" class="form-control" value="{{$siteSetting->email}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Facebook</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="facebook" class="form-control" value="{{$siteSetting->facebook}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Twitter</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="twitter" class="form-control" value="{{$siteSetting->twitter}}" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Copyright</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="copyright" class="form-control" value="{{$siteSetting->copyright}}" />
											</div>
										</div>
										
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Logo</label>
                                            <input type="file" name="logo" class="form-control" value="{{$siteSetting->logo}}" id="image" />
									    </div>
                                        <div class="mb-3">
										   <label for="exampleInputEmail1" class="form-label"></label>
										   <img id="showImage" src="{{ $siteSetting->logo == 'logo.png' ? asset('uploads/logo/logo.png') : asset($siteSetting->logo) }}" alt="logo" class="rounded-circle p-1 bg-primary" width="80">
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

	
            <script type="text/javascript">
               $(document).ready(function(){
				$('#image').change(function(e){
				     console.log('Image sélectionnée');
					var reader = new FileReader();
					reader.onload = function(e){
						$("#showImage").attr('src', e.target.result)
					}
					reader.readAsDataURL(e.target.files['0'])
				})
			   })
		   </script>

@endsection