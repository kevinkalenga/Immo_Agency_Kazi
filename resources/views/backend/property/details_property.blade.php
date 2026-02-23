@extends('admin.admin_dashboard')

@section('admin') 

<div class="page-content">

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Basic Table</h6>
        <p class="text-muted mb-3">
          Add class <code>.table</code>
        </p>

        <div class="table-responsive">
          <table class="table table-striped">
        
            <tbody>
              <tr>
                 <td>Property Name</td>
                 <td><code>{{$property->property_name}}</code></td>
              </tr>
              <tr>
                  <td>Property Status</td>
                  <td><code>{{$property->property_status}}</code></td>
              </tr>
              <tr>
                  <td>Lowest Price</td>
                  <td><code>{{$property->lowest_price}}</code></td>
              </tr>
              <tr>
                  <td>Maxim Price</td>
                  <td><code>{{$property->max_price}}</code></td>
              </tr>
              <tr>
                  <td>Bedrooms</td>
                  <td><code>{{$property->bedrooms}}</code></td>
              </tr>
              <tr>
                  <td>Bathrooms</td>
                  <td><code>{{$property->bathrooms}}</code></td>
              </tr>
              <tr>
                  <td>Garage</td>
                  <td><code>{{$property->garage}}</code></td>
              </tr>
              <tr>
                  <td>Garage Size</td>
                  <td><code>{{$property->garage_size}}</code></td>
              </tr>
              <tr>
                  <td>Address</td>
                  <td><code>{{$property->address}}</code></td>
              </tr>
              <tr>
                  <td>City</td>
                  <td><code>{{$property->city}}</code></td>
              </tr>
              <tr>
                  <td>State</td>
                  <td><code>{{$property->state}}</code></td>
              </tr>
              <tr>
                  <td>Post Code</td>
                  <td><code>{{$property->postal_code}}</code></td>
              </tr>
              <tr>
                  <td>Main Image</td>
                  <td>
                    <img src="{{asset($property->property_thambnail)}}" style="width:100px; height:70px; border-raduis:50%;">
                  </td>
              </tr>
              <tr>
                  <td>Status</td>
                  <td>
                        @if($property->status == 1)
                          <span class="badge rounded-pill bg-success">Active</span>
                        @else 
                          <span class="badge rounded-pill bg-danger">Inactive</span>
                        @endif
                  </td>
              </tr>
            
            
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>


  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-striped">
           
            <tbody>
              <tr>
                  <td>Property Code</td>
                  <td><code>{{$property->property_code}}</code></td>
              </tr>
              <tr>
                  <td>Property Size</td>
                  <td><code>{{$property->property_size}}</code></td>
              </tr>
              <tr>
                  <td>Property Video</td>
                  <td><code>{{$property->property_video}}</code></td>
              </tr>
              <tr>
                  <td>Neighborhood</td>
                  <td><code>{{$property->neighborhood}}</code></td>
              </tr>
              <tr>
                  <td>Latitude</td>
                  <td><code>{{$property->latitude}}</code></td>
              </tr>
              <tr>
                  <td>Longitude</td>
                  <td><code>{{$property->longitude}}</code></td>
              </tr>
              <tr>
                  <td>Property Type</td>
                  <td><code>{{$property->type->type_name}}</code></td>
              </tr>
              <tr>
                  <td style="width: 30%; font-weight: 600;">Property Amenities</td>
                  <td>
                    <div class="row">
                      @foreach($amenities as $amenitie)
                        @if(in_array($amenitie->id, $property_ami))
                          <div class="col-md-6 mb-1">
                            <i class="mdi mdi-check-circle-outline text-success me-1"></i>
                            {{ $amenitie->amenities_name }}
                          </div>
                        @endif
                      @endforeach
                    </div>
                  </td>
              </tr>
              <tr> 
                  <td>Agent</td>
                  <td>
                    @if($property->agent_id == NULL)
                       <td><code> Admin </code></td>
                    @else
                       <td><code> {{ $property['user']['name'] }} </code></td>
                    @endif
                  </td>
              </tr>
              
          
            </tbody>
          </table>
        </div>

      </div>
    </div>

</div>








</div> 



       

</div>

@endsection