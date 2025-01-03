@extends('layouts.app')

@section('content')
<div style="max-width: 100%;" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-header">What do you think ?</div>

                <form class="needs-validation" id="formPost">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Title</span>
                            </div>
                            <input type="text" required="required" class="form-control" placeholder="Title" name="title" aria-label="title" aria-describedby="basic-addon1">
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <select required class="dropdown select2" name="category" style="width:100%">
                                    <option class="btn btn-dark dropdown-toggle" value="" selected="selected" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select a category
                                    </option>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($categorieRows as $category)
                                        <option class="dropdown-item" name="category" value="{{ $category->title }}">{{ $category->title }}</option>
                                        @endforeach
                                    </div>
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="dropdownMenuButton">Tags</span>
                                <select required class="dropdown select2Tags form-control" multiple="multiple" name="tags[]" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Content</span>
                            </div>
                            <textarea class="form-control" required="required" placeholder="Explain the Content" name="content" aria-label="content" style="height:200px;"></textarea>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-lg btn-block btn-dark">Post</button>
                    </div>
                </form>
                
            </div>
            <div class="card mb-5">
                <div class="card-footer">
                    <input type="text" class="form-control" placeholder="Search Post" id="search" >
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach($postRows as $post)
        @php
            $likes = !is_null($post->user_like) ? 'text-success' : 'text-info';
        @endphp
        <div style="padding:0;" class="card col-md-2 mr-2 ml-2 mb-3 cardPost">
            <div class="card-header">
                <div class="text-right">Category: <a href="/category/{{ $post->category }}">{{ $post->category }}</a></div>
            </div>
            @if (!empty($post->image))
            <img class="card-img-top" width="200" height="200" src="/uploads/posts/{{ $post->image }}" alt="{{ $post->title }}">
            @endif
            <div class="card-body">
                <h5 class="card-title"> <a href="post/{{ $post->category }}/{{$post->id}}">{{ $post->title }}</a></h5>
                <p class="card-text">{{ str_limit($post->content, 100) }}</p>
                <p class="card-text"><small class="text-muted">Last Updated: {{ $post->updated_at->format('dS-F-Y, h:i A') }}</small></p>
            </div>
            <div class="card-footer text-muted">
                @if(Auth::user()->id === $post->user_id)
                <div class="text-left">Posted By: <a href="/author/{{$post->user_id}}">You</a></div>
                @else
                <div class="text-left">Posted By: <a href="/author/{{$post->user_id}}">{{ @$post->user->name }}</a></div>
                @endif
                <div class="text-left tags_">Tags: {{ $post->tags }}</div>
                <div class="text-right" ><a href="javascript:;" class="like {{$likes}}" id_post="{{ $post->id }}" id_user="{{ Auth::user()->id }}" style="font-weight: bold;">Like</a></div>
            </div>
            @if((Auth::user()->id === $post->user_id) || (Auth::user()->type === "admin"))
            <div class="card-footer text-muted">
                <div class="row">
                    <!-- <a href="/edit/{{$post->category}}/{{$post->id}}" class="btn btn-md btn-warning mb-2 col-md-6">Edit</a> -->
                    <a href="/delete/{{$post->id}}" onclick="return confirm('Are you sure?')" class="btn btn-md btn-danger mb-2 col-md-12">Delete</a>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".select2Tags").each(function(index, element) {
          $(this).select2({
            tags: true,
            width: 550, // just for stack-snippet to show properly
          });
        });

        $('#formPost').submit(function (e) {
            e.preventDefault();
            let formData = new FormData($('#formPost')[0]);

            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}", Accept: "application/json",},
                url: "{{ url('submitPost') }}",
                type: "POST",
                data: formData,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function (resp) {
                    if(resp.status == true){
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 1300
                        }).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            position: 'centered',
                            icon: 'error',
                            title: `${resp.message}`,
                            showConfirmButton: true,
                            timer: 1500
                        }).then((result) => {
                        });
                    }
                },
                error: function (data) {
                }
            });
        });

        $('.like').click(function (e) {
            e.preventDefault();
            let idPost = $(this).attr('id_post');
            let idUser = $(this).attr('id_user');
            
            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}", Accept: "application/json",},
                url: "{{ url('likePost') }}",
                type: "POST",
                data: {id_post:idPost, id_user:idUser},
                dataType: 'json',
                success: function (resp) {
                    if(resp.status == true){
                        
                        $(`.like[id_post="${idPost}"]`).addClass('text-success').removeClass('text-info');
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 1000
                        }).then((result) => {
                            // window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            position: 'centered',
                            icon: 'error',
                            title: `${resp.message}`,
                            showConfirmButton: true,
                            timer: 1500
                        }).then((result) => {
                        });
                    }
                },
                error: function (data) {
                }
            });
        });

        $("#search").keyup(function(){
            var v = new RegExp($('#search').val().toLowerCase(), "g");
            $('.tags_').each(function(){
                var name = $(this).text().toLowerCase();
                if(v.test(name)){
                    $(this).parent().parent().show(); 
                }else{
                    $(this).parent().parent().hide(); 
                }
            });
        });
    });
</script>
    
@endsection