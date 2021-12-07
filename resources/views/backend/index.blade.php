@extends('backend.master')
@section('content')
<!-- Modal -->
<div class="modal fade" id="AddNewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="AddNote" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" id="title">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Content</label>
                        <input type="text" name="content" class="form-control" id="content">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary add_inote" id="create-note">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="noteEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="EditNote" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" id="title1">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Content</label>
                        <input type="text" name="content" class="form-control" id="content1">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control" id="image1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_inote">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<main>
    <div class="container-fluid px-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">

            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th colspan="2" style="text-align: center">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inotes as $key => $inote)
                    <tr id="sid_{{ $inote->id }}">
                        <td>{{ $loop->index +1}}</td>
                        <td>{{ $inote->title }}</td>
                        <td>{{ $inote->content }}</td>
                        <td>{{ $inote->image }}</td>
                        <td>
                            <a href="javascript:void(0)"><button type="button" class="btn btn-success"
                                    data-toggle="modal" data-target="#noteEditModal">
                                    Edit
                                </button></a>
                        </td>
                        <td>
                            <button onclick="deleteNote({{ $inote->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</main>
@endsection
@section('scripts')

<script>
    $(document).ready(function () {
        $(document).on('click','#create-note',function (e) {
            e.preventDefault();

            let formData = new FormData($('#AddNote')[0]);

            $.ajax({
                type: "POST",
                url: "/home",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.errors, function (indexInArray, valueOfElement) { 
                             
                        });
                    }
                }
            });

        });
    });

</script>

<script>
    function editNote() {
       $.get('/home/'+id,function(note) {
           $("#id").val(note.id);
           $("#title1").val(note.title);
           $("#content1").val(note.content);
           $("#image1").val(note.image);
           $("#noteEditModal").modal('toggle');
       })
    }

</script>

<script>
    function deleteNote(id) {
        if(confirm("Do you realy want to delete this record?"))
        {   
            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
            $.ajax({
                url: origin + `/home/delete/${id}`,
                type:'DELETE',
                success:function(response)
                {
                    console.log(response);
                    $("#sid_" + id).remove();
                },
                error:function(error){

                }
            })
        }        
    }

</script>
@endsection