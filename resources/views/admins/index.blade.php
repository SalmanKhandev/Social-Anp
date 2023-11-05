@extends('layouts.master')

@section('styles')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.error-message {
    color: red;
    margin-left: 2px;
}
</style>
@endsection


@section('content')
<section class="section">
    <div class="section-body">
    <div class="row">
       
        <div class="col-12 ">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Admins</h4>
            <button data-toggle="modal" data-target="#addModal" class="btn btn-primary text-right">Add Admin</button>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>


            @foreach($admins as $index=> $admin)
                @php
                    $index ++;
                @endphp
                <tr data-admin="{{$admin}}">
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    <td>Admin</td>
                    <td>
                   <div class="buttons">
                      <a href="#" data-toggle="modal" data-target="#editModal"  class="btn btn-icon edit-btn btn-primary"><i class="far fa-edit"></i></a>
                      <a href="#" data-id={{$admin->id}} class="btn btn-icon delete-admin btn-danger"><i class="fas fa-times"></i></a>
                    </div>
                    </td>     
                </tr>

            @endforeach

                </table>
            </div>
            </div>
            {{-- <div class="card-footer text-right">
            <nav class="d-inline-block">
                <ul class="pagination mb-0">
                
                <li class="page-item active"><a class="page-link" href="#">1 <span
                        class="sr-only">(current)</span></a></li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
                </ul>
            </nav>
            </div> --}}
        </div>
        </div>
    </div>
 

    </div>
    
</section>
  <!-- Modal with form -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">Add Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="">
                    <div class="form-group">
                    <label>Full Name</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-user"></i>
                        </div>
                      </div>
                      <input type="text" id="name" required class="form-control" placeholder="Name" name="name">
                        <div class="error-message" id="name-error"></div>

                    </div>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
                      <input type="email" id="email" required class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="error-message" id="email-error"></div>
                </div>
                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <input type="password" id="password" required class="form-control" placeholder="Password" name="password">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary add-admin m-t-15 waves-effect">Create Admin</button>
                </form>
              </div>
            </div>
          </div>
        </div>



         <!-- Modal with form -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">Update Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="">
                    <div class="form-group">
                    <input type="hidden" name="user_id" value="" id="user_id">
                    <label>Full Name</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-user"></i>
                        </div>
                      </div>
                      <input type="text" id="edit-name" required class="form-control" placeholder="Name" name="name">
                        <div class="error-message" id="name-error"></div>

                    </div>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
                      <input type="email" id="edit-email" required class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="error-message" id="email-error"></div>
                </div>
                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <input type="password" id="password" required class="form-control" placeholder="Password" name="password">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary edit-admin m-t-15 waves-effect">Create Admin</button>
                </form>
              </div>
            </div>
          </div>
        </div>
@endsection





@section('scripts')

<script>

$(document).ready(function(){

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $(".delete-admin").click(function(){
    var id=$(this).data('id');
    var url='{{ route("admin.deleteAdmin") }}';
    var status = $(this).is(':checked') ? 1 : 0;
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Delete Admin",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText:'Cancel',
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success: function(response)
        {
            console.log(response);
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
                 setTimeout(function(){
                    location.reload(true)
                }, 3000);
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        }
    });
    }
});

  });


  $(".add-admin").click(function(event){
     event.preventDefault();
     var name = $("#name").val();
     var email = $("#email").val();
     var password = $("#password").val();
     var url = "{{route('admin.createAdmin')}}";
       $.ajax({
        type: 'POST',
        url: url,
        data: {
            name:name,
            email:email,
            password:password
        },
        success: function(response)
        {
            console.log(response);
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
                $("#addModal").modal('hide');
                setTimeout(function(){
                    location.reload(true)
                }, 3000);
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        },
        error: function(response) {
            if (response.status === 422) {
                var errors = response.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    var errorMessages = messages.join('<br>');
                    $('#' + field + '-error').html(errorMessages);
                });
            }
        }
    });
  });



  
  $(".edit-admin").click(function(event){
     event.preventDefault();
     var name = $("#edit-name").val();
     var email = $("#edit-email").val();
     var password = $("#edit-password").val();
     var user_id = $("#user_id").val();
     var id = $()
     var url = "{{route('admin.updateAdmin')}}";
       $.ajax({
        type: 'POST',
        url: url,
        data: {
            name:name,
            email:email,
            password:password,
            user_id:user_id
        },
        success: function(response)
        {
            console.log(response);
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
                $("#addModal").modal('hide');
                setTimeout(function(){
                    location.reload(true)
                }, 3000);
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        },
        error: function(response) {
            if (response.status === 422) {
                var errors = response.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    var errorMessages = messages.join('<br>');
                    $('#' + field + '-error').html(errorMessages);
                });
            }
        }
    });
  });


 $(".edit-btn").click(function(){
    var admin= $(this).closest('tr').data('admin');
    $("#edit-name").val(admin.name);
    $("#edit-email").val(admin.email);
    $("#user_id").val(admin.id);
 });

});


</script>

@endsection