@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">

    <div class="row profile-body">

        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Post</h6>

                        <form class="forms-sample"
                              action="{{ route('update.post', $post->id) }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Post Title</label>
                                        <input type="text" class="form-control" name="post_title"  value="{{ $post->post_title }}" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Blog Category</label>
                                        <select name="blogcat_id" class="form-select" id="exampleFormControlSelect1">
                                            <option selected="" disabled="">Select Category</option>
                                            @foreach($blogCat as $cat)
                                                <option value="{{$cat->id}}" {{$cat->id == $post->blogcat_id ? 'selected' : ''}}>{{$cat->category_name}}</option>
                                            
                                            @endforeach           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-sm-12">
								<div class="mb-3">
									<label class="form-label">Short Description</label>
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_descp">
                                      {!! $post->short_descp !!}
                                    </textarea>
								</div>
							</div><!-- Col -->
							<div class="col-sm-12">
								<div class="mb-3">
									<label class="form-label">Long Description</label>
									<textarea class="form-control" id="tinymceExample" rows="10" name="long_descp">
                                         {!! $post->long_descp !!}
                                    </textarea>
								</div>
							</div>
                            
                            
                            <div class="col-sm-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">Post Tags</label>
                                    <input name="post_tags" id="tags" value="Realestate," value="{{ $post->post_tags }}" />
                                </div>
                            </div>
                            
                            
                            
                            <!-- Photo Upload -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Post Photo</label>
                                <input type="file" name="post_image" class="form-control" id="image" />
                            </div>

                            <!-- Preview Image -->
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label"></label>
                                <img src="{{asset($post->post_image)}}" alt="State Image" 
                                     class="previewImage rounded-circle p-1 bg-primary"
                                     width="80" height="80">
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