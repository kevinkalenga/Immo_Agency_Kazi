@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">

    <div class="row profile-body">

        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit State</h6>

                        <form class="forms-sample"
                              action="{{ route('update.state', $state->id) }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf
                           

                            <!-- State Name -->
                            <div class="mb-3">
                                <label class="form-label">State Name</label>
                                <input name="state_name"
                                       type="text"
                                       value="{{ $state->state_name }}"
                                       class="form-control @error('state_name') is-invalid @enderror" />

                                @error('state_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Photo Upload -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">State Photo</label>
                                <input type="file" name="state_image" class="form-control" id="image" />
                            </div>

                            <!-- Preview Image -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label"></label>
                                <img src="{{ asset($state->state_image) }}"
                                     alt="State Image"
                                     class="previewImage rounded-circle p-1 bg-primary"
                                     width="80"
                                     height="80">
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary me-2">
                                Update Changes
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