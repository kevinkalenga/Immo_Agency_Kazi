@extends('admin.admin_dashboard')

@section('admin') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

       
        <div class="row profile-body">
         
          <!-- middle wrapper start -->
          <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                  
                    <div class="card">
							<div class="card-body">
								<h6 class="card-title">Add Properties</h6>
									<form>
										
									    <div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Proprty Name</label>
													<input type="text" class="form-control" name="property_name" >
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Property Status</label>
													<select name="property_status" class="form-select" id="exampleFormControlSelect1">
											            <option selected="" disabled="">Select Status</option>
											            <option value="rent">For Rent</option>
											            <option value="buy">For Buy</option>
											           
										            </select>
												</div>
											</div><!-- Col -->
										
										    <div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Lowest Price</label>
													<input type="text" class="form-control" name="lowest_price" >
												</div>
											</div>
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Max Price</label>
													<input type="text" class="form-control" name="max_price" >
												</div>
											</div>
										    <div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Main Thambnail</label>
													<input type="file" class="form-control" name="property_thambnail" onChange="mainThamUrl(this)">
													<img src="" alt="" id="mainThmb">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Multiple Image</label>
													<input type="file" class="form-control" name="multi_img[]" id="multiImg" multiple="">
													<div class="row" id="preview_img"></div>
												</div>
											</div>
										
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">BedRooms</label>
													<input type="text" class="form-control" name="bedrooms">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">BathRooms</label>
													<input type="text" class="form-control" name="bathrooms">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Garage</label>
													<input type="text" class="form-control" name="garage">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Garage Size</label>
													<input type="text" class="form-control" name="garage_size">
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Address</label>
													<input type="text" class="form-control" name="address">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">City</label>
													<input type="text" class="form-control" name="city">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">State</label>
													<input type="text" class="form-control" name="state">
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Postal Code</label>
													<input type="text" class="form-control" name="postal_code">
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Property Size</label>
													<input type="text" class="form-control" name="property_size">
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Property Video</label>
													<input type="text" class="form-control" name="property_video">
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Neighborhood</label>
													<input type="text" class="form-control" name="neighborhood">
												</div>
											</div><!-- Col -->
											
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Latitude</label>
													<input type="text" class="form-control" name="latitude">
													 <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get Latitude from address</a>
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Longitude</label>
													<input type="text" class="form-control" name="longitude">
													  <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get Longitude from address</a>
												</div>
											</div><!-- Col -->
										</div><!-- Row -->


										<div class="row">
                                           <div class="col-sm-4">
                                              <div class="mb-3">
                                                  <label class="form-label">Property Type </label>
                                                  <select name="property_id" class="form-select" id="exampleFormControlSelect1">
											            <option selected="" disabled="">Select Type</option>
													    @foreach($propertyType as $ptype)
											               <option value="{{$ptype->id}}">{{$ptype->type_name}}</option>
											            @endforeach
											      </select>
											  </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">

                                                <div class="mb-3">
                                                   <label class="form-label">Property Amenities </label>
                                                     <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
										                @foreach($amenities as $amenitie)
											               <option value="{{$amenitie->id}}">{{$amenitie->amenities_name}}</option>
											            @endforeach
										              
									                 </select>
                                                </div>
                                            </div><!-- Col -->
                                            <div class="col-sm-4">
                                                <div class="mb-3">
                                                   <label class="form-label"> Agent </label>
                                                   <select name="agent_id" class="form-select" id="exampleFormControlSelect1">
											            <option selected="" disabled="">Select Agent</option>
													    @foreach($activeAgent as $agent)
											               <option value="{{$agent->id}}">{{$agent->name}}</option>
											            @endforeach
											      </select>
                                                </div>
                                            </div><!-- Col -->

                                        </div>
										<div class="col-sm-12">
												<div class="mb-3">
													<label class="form-label">Short Description</label>
												    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
												</div>
										</div><!-- Col -->
										<div class="col-sm-12">
												<div class="mb-3">
													<label class="form-label">Long Description</label>
													 <textarea class="form-control" name="tinymce" id="tinymceExample" rows="10"></textarea>
												</div>
										</div><!-- Col -->
										

                                        <hr>

                                        <div class="mb-3">
                                           <div class="form-check form-check-inline">
                                                <input type="checkbox" name="featured" value="1" class="form-check-input" id="checkInline1">
                                                <label class="form-check-label" for="checkInline1">
                                                    Features Property 
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="hot" value="1" class="form-check-input" id="checkInline">
                                                <label class="form-check-label" for="checkInline">
                                                    Hot Property 
                                                </label>
                                            </div>
                                        </div>
                                    </form>
									<button type="button" class="btn btn-primary submit">Submit form</button>
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
  
<script type="text/javascript">
	function mainThamUrl(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#mainThmb').attr('src', e.target.result).width(80).height(80);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>	



<script> 
 
  $(document).ready(function(){
   $('#multiImg').on('change', function(){ //on file input change
      if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
      {
          var data = $(this)[0].files; //this file data
           
          $.each(data, function(index, file){ //loop though each file
              if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                  var fRead = new FileReader(); //new filereader
                  fRead.onload = (function(file){ //trigger function on successful read
                  return function(e) {
                      var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                  .height(80); //create image element 
                      $('#preview_img').append(img); //append image to output element
                  };
                  })(file);
                  fRead.readAsDataURL(file); //URL representing the file's data.
              }
          });
           
      }else{
          alert("Your browser doesn't support File API!"); //if File API is absent
      }
   });
  });
   
  </script>

@endsection