@extends('admin.admin_dashboard')

@section('admin') 

	<div class="page-content">

       
        <div class="row profile-body">
         
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                  <div class="card">
              <div class="card-body">

								<h6 class="card-title">Add Amenities</h6>

								<form class="forms-sample" action="{{route('store.type')}}" method="POST" >
                                    @csrf 
									        
									<div class="mb-3">
										<label class="form-label">Amenities Name</label>
										<input name="amenities_name" type="text" class="form-control @error('amenities_name') is-invalid @enderror" />
                     	                    @error('amenities_name') 
                                              <span class="text-danger">{{$message}}</span>
											 @enderror
									</div>
								
						
									
									
									
								
									
									<button type="submit" class="btn btn-primary me-2">Save Changes</button>
									
								</form>

              </div>
            </div>
            
            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
          
          <!-- right wrapper end -->
        </div>

			</div>

    
    
		

@endsection