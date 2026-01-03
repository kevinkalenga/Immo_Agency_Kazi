@extends('admin.admin_dashboard')

@section('admin') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

       
        <div class="row profile-body">
         
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                  <div class="card">
              <div class="card-body">

								<h6 class="card-title">Edit Amenities</h6>

								<form id="myForm" class="forms-sample" action="{{route('update.amenitie', $amenities->id)}}" method="POST" >
                                    @csrf 
									        
									<div class="mb-3">
										<label class="form-label">Amenities Name</label>
										<input name="amenities_name" type="text" class="form-control" value="{{$amenities->amenities_name}}" />
            
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

<script type="text/javascript">
$(document).ready(function () {
    $('#myForm').validate({
        rules: {
            amenities_name: {
                required: true,
            },
            
        },
        messages: {
            amenities_name: {
                required: 'Please Enter Amenities Name',
            },
            
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});
</script>
    
		

@endsection