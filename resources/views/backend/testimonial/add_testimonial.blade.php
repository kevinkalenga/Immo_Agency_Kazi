@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">

    <div class="row profile-body">

        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Testimonial</h6>

                        <form class="forms-sample"
                              action="{{ route('store.testimonials') }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf

                            <!-- State Name -->
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input name="name"
                                       type="text"
                                       class="form-control @error('name') is-invalid @enderror" />

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input name="position"
                                       type="text"
                                       class="form-control @error('position') is-invalid @enderror" />

                                @error('position')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Photo Upload -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Testimonial Photo</label>
                                <input type="file" name="image" class="form-control" id="image" />
                            </div>

                            <!-- Preview Image -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label"></label>
                                <img src="{{url('uploads/no_image.jpg')}}" alt="Image" 
                                     class="previewImage rounded-circle p-1 bg-primary"
                                     width="80" height="80">
                            </div>

                            <div class="mb-3">
								<label for="exampleFormControlTextarea1" class="form-label">Message</label>
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
							</div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary me-2">
                                Save Changes
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- IMAGE PREVIEW SCRIPT -->
 	

<script type="text/javascript">
  document.getElementById('image').addEventListener('change', function(e){

    const file = e.target.files[0];
    if(!file) return;

    const img = this.closest('form').querySelector('.previewImage');

    const reader = new FileReader();

    reader.onload = function(event){
        img.src = event.target.result;
    }

    reader.readAsDataURL(file);
});
</script>



@endsection