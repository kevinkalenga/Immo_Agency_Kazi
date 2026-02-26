@extends('agent.agent_dashboard')

@section('agent') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">

    <!-- Edit Properties -->
    <div class="row profile-body">
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Properties</h6>
                        <form method="post" action="{{route('agent.update.propertie', $property->id)}}" id="propertyForm" enctype="multipart/form-data">
                            @csrf
                           
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Property Name</label>
                                        <input type="text" class="form-control" name="property_name" value="{{$property->property_name}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Property Status</label>
                                        <select name="property_status" class="form-select" id="exampleFormControlSelect1">
                                            <option selected="" disabled="">Select Status</option>
                                            <option value="rent" {{$property->property_status == 'rent' ? 'selected':''}}>For Rent</option>
                                            <option value="buy" {{$property->property_status == 'buy' ? 'selected':''}}>For Buy</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Prices -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Lowest Price</label>
                                        <input type="text" class="form-control" name="lowest_price" value="{{$property->lowest_price}}" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Max Price</label>
                                        <input type="text" class="form-control" name="max_price" value="{{$property->max_price}}" >
                                    </div>
                                </div>
                                
                            </div>
                            <!-- Rooms -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">BedRooms</label>
                                        <input type="text" class="form-control" name="bedrooms" value="{{$property->bedrooms}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">BathRooms</label>
                                        <input type="text" class="form-control" name="bathrooms" value="{{$property->bathrooms}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Garage</label>
                                        <input type="text" class="form-control" name="garage"  value="{{$property->garage}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Garage Size</label>
                                        <input type="text" class="form-control" name="garage_size"  value="{{$property->garage_size}}">
                                    </div>
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{$property->address}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" name="city" value="{{$property->city}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">State</label>
                                        <input type="text" class="form-control" name="state" value="{{$property->state}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input type="text" class="form-control" name="postal_code" value="{{$property->postal_code}}">
                                    </div>
                                </div>
                            </div>
                            <!-- Property Size / Video / Neighborhood -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Property Size</label>
                                        <input type="text" class="form-control" name="property_size" value="{{$property->property_size}}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Property Video</label>
                                        <input type="text" class="form-control" name="property_video" value="{{$property->property_video}}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Neighborhood</label>
                                        <input type="text" class="form-control" name="neighborhood" value="{{$property->neighborhood}}">
                                    </div>
                                </div>
                            </div>
                            <!-- Latitude / Longitude -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" class="form-control" name="latitude" value="{{$property->latitude}}">
                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get Latitude from address</a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" class="form-control" name="longitude" value="{{$property->longitude}}">
                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get Longitude from address</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Property Type / Amenities / Agent -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Property Type</label>
                                        <select name="ptype_id" class="form-select" required>
                                            <option selected="">Select Type</option>
                                            @foreach($propertyType as $ptype)
                                                <option value="{{$ptype->id}}" {{$ptype->id == $property->ptype_id ? 'selected':''}}>{{$ptype->type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Property Amenities</label>
                                        <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                            @foreach($amenities as $amenitie)
                                                <option value="{{$amenitie->id}}" {{(in_array($amenitie->id, $property_ami)) ? 'selected': ''}}>{{$amenitie->amenities_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                            <!-- Short / Long Description -->
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" rows="3" name="short_descp">{!! $property->short_descp !!}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Long Description</label>
                                    <textarea class="form-control" id="tinymceExample" rows="10" name="long_descp">{!! $property->long_descp !!}</textarea>
                                </div>
                            </div>
                            <hr>
                            <!-- Featured / Hot -->
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="featured" value="1" class="form-check-input" {{$property->featured == '1' ? 'checked':'' }}>
                                    <label class="form-check-label">Features Property</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="hot" value="1" class="form-check-input" {{$property->hot == '1' ? 'checked':'' }}>
                                    <label class="form-check-label">Hot Property</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary submit">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Thumbnail Update -->
    <!-- ... (section unchanged, comme ton code original) ... -->
     <!-- ================== UPDATE MAIN THUMBNAIL ================== -->
      <div class="page-content" style="margin-top: 25px;">                
    <div class="row profile-body">           
        <div class="col-md-12 col-xl-12 middle-wrapper">            
            <div class="row">              
                <div class="card">    
                    <div class="card-body">        
                        <h6 class="card-title">Edit Main Thambnail Image</h6>

                        <form method="post"
                              action="{{ route('agent.update.propertie.thambnail') }}"
                              id="myForm"
                              enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $property->id }}">
                            <input type="hidden" name="old_img" value="{{ $property->property_thambnail }}">

                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Main Thambnail</label>
                                    <input type="file"
                                           name="property_thambnail"
                                           class="form-control"
                                           onChange="mainThamUrl(this)">
                                    <img src="" id="mainThmb">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label"></label>
                                    <img src="{{ asset($property->property_thambnail) }}"
                                         style="width:100px; height:100px;">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Multi Images Update -->
    <!-- ... (section unchanged, comme ton code original) ... -->
     <!-- ================== UPDATE MULTI IMAGES ================== -->
      <div class="page-content" style="margin-top: -35px;" > 
       
    <div class="row profile-body"> 
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Multi Image</h6>

                        <form method="post"
                              action="{{ route('agent.update.propertie.multiimage', $property->id) }}"
                              id="myForm"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Image</th>
                                            <th>Change Image</th>
                                            <th>Delete</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($multiImage as $key => $img)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td class="py-1">
                                                <img src="{{ asset($img->photo_name) }}"
                                                     alt="image"
                                                     style="width:50px; height:50px;">
                                            </td> 
                                           
                                            <td>
                                                <input type="file"
                                                       class="form-control"
                                                       name="multi_img[{{ $img->id }}]">
                                            </td>

                                            <td>
                                                <input type="submit" class="btn btn-primary px-4" value="Update Image" >
                                                <a href="{{ route('agent.propertie.multiimg.delete', $img->id) }}"
                                                   class="btn btn-danger">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                           

                        </form> 
                                                  		<form method="post" action="{{ route('store.new.multiimage') }}" id="myForm" enctype="multipart/form-data">
          @csrf
		  <input type="hidden" name="property_id" value="{{$property->id}}">
		  <table class="table table-striped">
		    <tbody>
		        <tr>
				  <td>
					<input type="file" name="multi_img[]" class="form-control" multiple required>
				  </td>
				  <td>
					 <input type="submit" class="btn btn-info px-4" value="Add Image">
				  </td>
			    </tr>
		
            </tbody>
          </table>
		</form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Facility Update -->
    <div class="page-content" style="margin-top: -35px;">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Property Facility</h6>
                            <form method="post" action="{{ route('update.propertie.facilities') }}" id="facilityForm" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="property_id" value="{{$property->id}}">
                                <div class="add_item">
                                    @foreach($facilities as $item)
                                        <div class="whole_extra_item_add">
                                            <div class="whole_extra_item_delete">
                                                <div class="container mt-2">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="facility_name">Facilities</label>
                                                            <select name="facility_name[]" class="form-control">
                                                                <option value="">Select Facility</option>
                                                                <option value="Hospital" {{$item->facility_name == 'Hospital' ? 'selected':''}}>Hospital</option>
                                                                <option value="SuperMarket" {{$item->facility_name == 'SuperMarket' ? 'selected':''}}>Super Market</option>
                                                                <option value="School" {{$item->facility_name == 'School' ? 'selected':''}}>School</option>
                                                                <option value="Entertainment" {{$item->facility_name == 'Entertainment' ? 'selected':''}}>Entertainment</option>
                                                                <option value="Pharmacy" {{$item->facility_name == 'Pharmacy' ? 'selected':''}}>Pharmacy</option>
                                                                <option value="Airport" {{$item->facility_name == 'Airport' ? 'selected':''}}>Airport</option>
                                                                <option value="Railways" {{$item->facility_name == 'Railways' ? 'selected':''}}>Railways</option>
                                                                <option value="Bus Stop" {{$item->facility_name == 'Bus Stop' ? 'selected':''}}>Bus Stop</option>
                                                                <option value="Beach" {{$item->facility_name == 'Beach' ? 'selected':''}}>Beach</option>
                                                                <option value="Mall" {{$item->facility_name == 'Mall' ? 'selected':''}}>Mall</option>
                                                                <option value="Bank" {{$item->facility_name == 'Bank' ? 'selected':''}}>Bank</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="distance">Distance</label>
                                                            <input type="text" name="distance[]" class="form-control" value="{{$item->distance}}">
                                                        </div>
                                                        <div class="form-group col-md-4" style="padding-top: 20px">
                                                            <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                                                            <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <br><br>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden template for adding facilities dynamically -->
    <div style="visibility: hidden">
        <div class="whole_extra_item_add">
            <div class="whole_extra_item_delete">
                <div class="container mt-2">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="facility_name">Facilities</label>
                            <select name="facility_name[]" class="form-control">
                                <option value="">Select Facility</option>
                                <option value="Hospital">Hospital</option>
                                <option value="SuperMarket">Super Market</option>
                                <option value="School">School</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Airport">Airport</option>
                                <option value="Railways">Railways</option>
                                <option value="Bus Stop">Bus Stop</option>
                                <option value="Beach">Beach</option>
                                <option value="Mall">Mall</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="distance">Distance</label>
                            <input type="text" name="distance[]" class="form-control" placeholder="Distance (Km)">
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 20px">
                            <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                            <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for add/remove facility rows -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on("click",".addeventmore",function(){
                var html = $(".whole_extra_item_add").first().html();
                $(".add_item").append(html);
            });
            $(document).on("click",".removeeventmore",function(){
                $(this).closest(".whole_extra_item_delete").remove();
            });
        });
    </script>

    <!-- Validation & Image Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#propertyForm').validate({
                rules: {
                    amenities_name: { required: true },
                    property_name: { required : true },
                    property_status: { required: true },
                    lowest_price: { required: true },
                    max_price: { required: true },
                    ptype_id: { required: true },
                    "multi_img[]": { required: true },
                },
                messages: {
                    amenities_name: { required: 'Please Enter Amenities Name' },
                    property_name: { required : 'Please Enter Property Name' },
                    property_status: { required : 'Please Select Property Status' },
                    lowest_price: { required : 'Please Enter Lowest Price' },
                    max_price: { required : 'Please Enter Max Price' },
                    ptype_id: { required : 'Please Select Property Type' },
                    "amenities_id[]": { required: true },
                    property_thambnail: { required: 'Please Select Property Image' },
                    "multi_img[]": { required: 'Please Select Property MultiImage' },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.after(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },
            });
        });

        function mainThamUrl(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThmb').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function(){
            $('#multiImg').on('change', function(){
                if (window.File && window.FileReader && window.FileList && window.Blob) {
                    var data = $(this)[0].files;
                    $.each(data, function(index, file){
                        if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){
                            var fRead = new FileReader();
                            fRead.onload = (function(file){
                                return function(e){
                                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(100).height(80);
                                    $('#preview_img').append(img);
                                };
                            })(file);
                            fRead.readAsDataURL(file);
                        }
                    });
                } else {
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
             });
  });
   
  </script> 

@endsection