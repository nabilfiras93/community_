@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-header">Hello, {{ Auth::user()->username }}! Have a question? Ask our users</div>

                <form class="needs-validation" novalidate method="POST" action="/updatePost" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <input type="hidden" name="post_id" value="{{ $postData->id }}">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Title</span>
                            </div>
                            <input type="text" value="{{ $postData->title }}" required="required" class="form-control" placeholder="State the problem" name="title" aria-label="title" aria-describedby="basic-addon1">
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <select class="dropdown" required="required" name="category" style="width:100%">
                                    <option class="btn btn-dark dropdown-toggle" selected="selected" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $postData->category }}
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
                                <select required class="dropdown select2Tags form-control" multiple="multiple" name="tags">
                                    @foreach($tags as $tag)
                                        <option class="dropdown-item" value="{{ $tag }}" selected>{{ $tag }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Content</span>
                            </div>
                            <textarea class="form-control" required="required" placeholder="Explain the problem in detail" name="content" aria-label="content">{{ $postData->content }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                            </div>
                            <span class="mb-2">Allow Comments:</span>
                            <span>
                                <div class="col-md-2 mb-3">
                                    <label class="switch">
                                        <input type="checkbox" name="flag" value="1" {{$postData->flag}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-lg btn-block btn-dark">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
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

    });
</script>
@endsection