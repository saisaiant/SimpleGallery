@extends('layouts.app')
@section('content')
<div class="container">
    @if (Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
    @endif
    {{-- Add Image --}}
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add Photo
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $albums->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" action="{{ route('album.image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{ $albums->id }}" class="form-control">
                        </div>
                        <div class="form-group initial-add-more">
                            <input type="file" class="form-control-file" name="image[]" id="image">
                            <button type="button" class="btn btn-success btn-add-more">Add</button>
                        </div>                
                        <div class="copy" style="display:none">
                            <div class="form-group add-more">
                                <input type="file" class="form-control-file" name="image[]" id="image">
                                <button type="button" class="btn btn-danger remove">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Add Image --}}
    <h1>{{ $albums->name }}({{ $albums->images->count() }})</h1>
    <div class="row">
        @foreach ($albums->images as $album)
        <div class="col-sm-4">
            <div class="item">
                <img src="{{ asset('storage/'.$album->name) }} " class="img-thumbnail">
            </div>
            <div>
                {{-- --}}
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    Delete
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Do You want to Delete?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('image.delete', $album->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
<style>
    .item {
        left: 0;
        top: 0;
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }

    .item img {
        -webkit-transition: 0.6s ease;
        transition: 0.6s ease;
    }

    .item img:hover {
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
    }

    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 24px;
    }

    .img-thumbnail {
        border: 0px;
        border-radius: 0px
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(e) {
        $('.btn-add-more').click(function() {
            let html = $('.copy').html();
            $('.initial-add-more').after(html);
        })
        $('body').on('click','.remove', function(){
            $(this).parents('.form-group').remove();
        })
    })
</script>