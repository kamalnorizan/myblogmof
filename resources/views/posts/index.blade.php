<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
        @foreach ($posts as $post)
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('posts.show', ['post'=>$post->uuid]) }}"> {{ $post->title }}</a> <small>~ {{ $post->user->name }} (<i>{{ $post->user->email }}</i>)</small>    <button type="button" class="btn btn-primary btn-sm float-right edit" data-uuid="{{ $post->uuid }}">
                            Edit
                          </button>
                    </h4>
                    <p class="card-text postContent">
                        {{ $post->content }}
                    </p>
                    <hr>
                    <h3>Comments ({{ $post->comments->count() }})</h3>
                    @foreach ($post->comments as $comment)
                        <p><strong>{{ $comment->user->id.') '.$comment->user->name }}({{ $comment->user->posts->count() }})</strong> {{ $comment->content }}</p>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editPost-mdl" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form method="POST" name="updatePostForm" id="updatePostForm">
                        @csrf
                        <input type="hidden" name="uuid" value="" id="uuid">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"  class="form-control" required="required">
                            <small class="text-danger">{{ $errors->first('title') }}</small>
                        </div>

                        <div class="form-group {{ $errors->has('author') ? 'has-error' : '' }}">
                            <label for="author">User</label>
                            <select id="author" name="author" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach ($users as $key => $user)
                                    <option {{ old('author') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $user }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('author') }}</small>
                        </div>

                        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                            <label for="content">Content</label>
                            <textarea id="content" name="content" class="form-control" required="required">{{ old('content') }}</textarea>
                            <small class="text-danger">{{ $errors->first('content') }}</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveEditPost" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var editBtn;
        $('.edit').click(function (e) {
            e.preventDefault();
            var uuid = $(this).data('uuid');
            editBtn = $(this);
            $.ajax({
                type: "post",
                url: "{{ route('posts.ajaxloadpost') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    uuid: uuid
                },
                dataType: "json",
                success: function (response) {
                    $('#uuid').val(response.uuid);
                    $('#title').val(response.title);
                    $('#author').val(response.author).change();
                    $('#content').val(response.content);

                    $('#editPost-mdl').modal('show');
                }
            });
        });

        $('#btnSaveEditPost').click(function (e) {
            e.preventDefault();
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');
            $.ajax({
                type: "post",
                url: "{{ route('posts.update') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    uuid: $('#uuid').val(),
                    title: $('#title').val(),
                    author: $('#author').val(),
                    content: $('#content').val()
                },
                dataType: "json",
                success: function (response) {
                    swal({
                      title: "Successfully Updated",
                      text: "The post already succesfully updated",
                      icon: "success",
                    }).then(function(){
                        // window.location.reload();
                        editBtn.closest('.card-body').find('h4 a').text($('#title').val());
                        editBtn.closest('.card-body').find('.postContent').text($('#content').val());
                        $('#editPost-mdl').modal('hide');
                    });

                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function (indexInArray, valueOfElement) {
                        $('#'+indexInArray).addClass('is-invalid');
                        $('#'+indexInArray).closest('.form-group').find('.text-danger').text(valueOfElement[0]);
                    });
                }
            });
        });
    </script>
  </body>
</html>
