@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
    <div class="row">
   
        <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
            <h4>Clear Posts </h4>
            </div>
            <div class="card-body">
            <div class="form-group">
                <label>Select</label>
                <select class="form-control" id="duration">
                <option>Select Duration</option>
                <option value="7">1 Week</option>
                <option value="14">2 Week</option>
                <option value="30">1 Month</option>
                <option value="60">2 Months</option>
                <option value="90">3 Months</option>
                </select>
                <br><br>
                <button type="button" class="btn btn-primary" id="delete-btn">Delete Posts</button>
            </div>   
         </div>
        </div>
       
        </div>
                <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
            <h4>Delete Posts </h4>
            </div>
            <div class="card-body">
            <div class="form-group">
                <label>Set Next Post Deletion Date</label>
                <input required id="posts_date" type="date" name="date"  min="<?php echo date("Y-m-d"); ?>" class="form-control">
                <button type="button" class="btn btn-primary mt-5" id="posts-delete-btn">Set Deletion Date</button>
            </div>   
         </div>
        </div>
       
        </div>
    </div>
    </div>
</section>
@endsection


@section('scripts')
<script>
    $("#delete-btn").click(function(){
    var duration = $("#duration").val();
    var url='{{ route("posts.deletePosts") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to delete  Posts",
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
        data: {
            'days':duration
        },
        beforeSend: function () {
            showLoader()
        },
        success: function(response)
        {
            if(response.status){
                showSwalMessage('success', 'Success', response.message)
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        },
        complete: function () {
            hideLoader()
        },
    });
    }
});

});



  $("#posts-delete-btn").click(function(){
    var duration = $("#posts_date").val();
    var url='{{ route("posts.deletion.date") }}';
        $.ajax({
        type: 'POST',
        url: url,
        data: {
            'date':duration
        },
        beforeSend: function () {
            showLoader()
        },
        success: function(response)
        {
            console.log(response);
            if(response.status){
                showSwalMessage('success', 'Success', response.message)
            }else{
                showSwalMessage('error', "Error", "{{__('lang.Something went Wrong! please try again!')}}")
            }
        },
        complete: function (error) {
            console.log(error);
            hideLoader()
        },
    });
    
    

});

</script>
@endsection