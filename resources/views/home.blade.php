@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="album" class="form-control" placeholder="Album Name">
            </div>
            <div class="form-group">                
                <input type="file" class="form-control-file" name="image[]">
                <input type="file" class="form-control-file" name="image[]">
                <input type="file" class="form-control-file" name="image[]">
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
        @foreach ($images as $image)
            <img src="{{ asset('storage/'.$image->name) }}" alt="" class="img-thumbnail">
        @endforeach
    </div> --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="show"></div>
                <div id="errormsg"></div>
                <div class="card-body">
                    <form id="form" action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="album" class="form-control" placeholder="Enter Album">
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
</div>
@endsection
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
<script>
    $(document).ready(function() {
        $('#form').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url:'/album',
                type:"POST",
                data: new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success: function(response) {
                    $('.show').html(response);
                    $('#form')[0].reset();
                    $('#errormsg').empty();
                },
                error: function(data) {
                    //alert('Error!');
                    let error = data.responseJSON;
                    $('#errormsg').empty();
                    $.each(error.errors, function(key,value) {
                        $('#errormsg').append('<p class="text-center text-danger">'+ value +'</p>');
                    });
                }
            })
        });
    })
</script>


