@extends('layouts.master')

@section('styles')
<style>
.blue-tag {
    color: blue; /* Set the color to blue or any other desired color */
}
.update-btn{
    display: flex;
    justify-content: flex-end; /* Move items to the right */
    align-items: center; /* Center vertically if needed */
}

.none{
    display: none;
}

</style>
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Categorize Posts</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                        <div class="update-btn">
                            <button type="button" class="btn btn-success none updateAllButton"  >Click to Categorize Posts</button><br><br><br>
                        </div>
                      <table class="table table-striped" id="reports-table">
                        <thead>
                          <tr>
                            <th>User</th>
                            <th>Platform</th>
                            <th>Post ID</th>
                            <th>Message</th>
                            <th>Tags</th>
                            <th>Categorize</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
          </div>
        </section>
@endsection


@section('scripts')
<script type="text/javascript">
  $(function () {
    
    var table = $('#reports-table').DataTable({
        processing: true,
        serverSide: true,
         ajax: {
                    url: "{{route('categorize.posts.all')}}",
                    type: 'get',
                    data: function (d) {
                        d.user_id = $("#user_id").val(),
                        d.from_date = $("#from_date").val(),
                        d.to_date = $("#to_date").val()
                    }
                },
        columns: [
            {
                data: 'user',
                title: 'User',
            },           
            {
                data: 'platform',
                name: 'Platform'
            },
            {
                data: 'post_id',
                "render":function(data,type,row){
                     if (type === 'display') {
                        return '<a>' + data+ '</a>';
                    }
                    return data; // For other types (sorting, type, etc.)
                }
            },
            {
                data: 'message',
                name: 'Message'
            },
            {
                data: 'tags',
                "render": function (data, type, row) {
                        return '<span class="blue-tag">' + data.join(', ') + '</span>'; // Wrap tags in a span with the class "blue-tag"
                    return data; // For other types (sorting, type, etc.)
                }
            },
            {
                "data": null,
               "render": function (data, type, full, meta) {
                    var postType = data.category; // Get the current post type
                    var personalChecked = postType === 'Personal' ? 'checked' : '';
                    var politicalChecked = postType === 'Political' ? 'checked' : '';

                    // Add radio buttons for selecting the post type
                    var postId = data.id;
                    var radioButtons = '<label class="radio-label"><input type="radio" name="post_type_' + postId + '" data-post-id="' + postId + '" value="Personal" ' + personalChecked + '> Personal</label>&nbsp;&nbsp;';
                    radioButtons += '<label class="radio-label"><input type="radio" name="post_type_' + postId + '" data-post-id="' + postId + '" value="Political" ' + politicalChecked + '> Political</label>';

                    return radioButtons;
                }
            },
        ],
        rowCallback: function(row, data) {
            console.log(data);
          
                }
    });


        $('#submit-search').click(function(){
            console.log("Done");
                $('#reports-table').DataTable().draw(true);
                            // table.ajax.reload();
            });
        $('#clear-filter').click(function(){
            $('.refresh').val('');
            $('#reports-table').DataTable().draw(true);
        });

        $('.updateAllButton').click(function(){
            showSwalMessage('success', 'Success', 'Posts Categorized successfully');
            $('#reports-table').DataTable().draw(true);
        });



//    Update Category Status
    var hasChanges = false;
    // Add an event listener for the radio buttons
    $('#reports-table').on('change', 'input[type="radio"]', function () {

        var postId = $(this).data('post-id'); // Extract the post_id
        var postType = $(this).val();

        hasChanges = true;
        showUpdateAllButton();
        // Call your function to update the post type here, passing postId and postType
        updatePostType(postId, postType);
    });


    // Define the function to update the post type in the database
    function updatePostType(postId, postType) {
        // Make an AJAX request to update the post type
        $.ajax({
            type: 'POST',
            url: "{{route('category.updateCategoryStatus')}}", // Replace with your Laravel route for updating posts
            data: {
                'post_id': postId,
                'post_type': postType
            },
            success: function (data) {
            //   $('#reports-table').DataTable().draw(true);
            }
        });
    }

     function showUpdateAllButton() {
        if (hasChanges) {
            console.log('Update All');
            $(".updateAllButton").removeClass('none');
        }
        else
        {
         $(".updateAllButton").addClass('none');

        }
    }
    
});


</script>
@endsection