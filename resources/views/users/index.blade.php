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
</style>
@endsection


@section('content')
<section class="section">
    <div class="section-body">
    <div class="row">
       
        <div class="col-12 ">
        <div class="card">
            <div class="card-header">
            <h4>All Users</h4>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Status</th>
                    <th>Accounts</th>
                    <th>Assing Role</th>
                    <th>Actions</th>
                </tr>


            @foreach($users as $index=> $user)
                @php
                    $index ++;
                @endphp
                <tr data-user="{{$user}}">
                    <td>{{$index}}</td>
                    <td><a href="{{route('users.user-profile',$user->id)}}">{{$user->name}}</a> </td>
                    <td>{{$user->email}}</td>
                    <td>
                     <img alt="image" style="margin-top: -15px;" src="https://static.vecteezy.com/system/resources/previews/009/734/564/original/default-avatar-profile-icon-of-social-media-user-vector.jpg" class="rounded-circle" width="70"
                        data-toggle="tooltip" title="{{$user->name}}">
                    </td>
                    <td> 
                    <label class="switch" >
                    <input type="checkbox" class="switch-btn" data-id={{$user->id}}      {{ $user->status==1 ? 'checked' : '' }}>
                    <span class="slider round"></span>
                    </label>
                    </td>
                    <td>
                      <a href="{{route('dashboard.posts.all',$user->id)}}" class="btn btn-social-icon mr-1 btn-facebook">
                      <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                        <i class="fab fa-instagram"></i>
                      </a>

                    </td>
                    <td>
                            <a href="#" class="btn btn-icon icon-left btn-dark assign-role" data-id={{$user->id}}><i class="far fa-user"></i> Make as Admin</a>
                    </td>
                    <td>
                       <a href="#" data-toggle="modal" data-target="#editModal" class="btn btn-icon btn-primary edit-btn " ><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger delete-user" data-id={{$user->id}}><i class="fas fa-times"></i></a>

                    </td>
                </tr>

            @endforeach

                </table>
            </div>
            </div>
            <div class="card-footer text-right">
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
            </div>
        </div>
        </div>
    </div>
 

    </div>

  
</section>

  
         <!-- Modal with form -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">Update User</h5>
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
                  <button type="submit" class="btn btn-primary edit-user m-t-15 waves-effect">Create Admin</button>
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

  $(".switch-btn").click(function(e){
    e.preventDefault()
    var id=$(this).data('id');
    var url='{{ route("user.updateStatus") }}';
    var status = $(this).is(':checked') ? 1 : 0;
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to update status",
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
        data: {status: status, id:id},
        success: function(response)
        {
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
                window.location.reload();
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        }
    });
    }
});


      
  });


    
  $(".edit-user").click(function(event){
     event.preventDefault();
     var name = $("#edit-name").val();
     var email = $("#edit-email").val();
     var password = $("#edit-password").val();
     var user_id = $("#user_id").val();
     var id = $()
     var url = "{{route('user.updateUser')}}";
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
    var user= $(this).closest('tr').data('user');
    console.log(user);
    $("#edit-name").val(user.name);
    $("#edit-email").val(user.email);
    $("#user_id").val(user.id);
 });




   $(".delete-user").click(function(){
    console.log("Clicked");
    var id=$(this).data('id');
    var url='{{ route("user.deleteUser") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Delete User",
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
        data: {user_id:id},
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











     $(".assign-role").click(function(){
    console.log("Clicked");
    var id=$(this).data('id');
    var url='{{ route("user.assignAdminRole") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Assign Admin Role to this User",
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
        data: {user_id:id},
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

});


</script>

@endsection