@extends('layouts.master')
@section('content')
    
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Twitter Tweets</h4>
                  </div>
                  <div class="card-body">
                  
                    <div class="tab-content" id="myTabContent2">
                    <div class="row">
                    <div class="col-12">
                            <table class="table" id="tweets">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Tweet Id</th>
                                <th scope="col">Message</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Last Updated On</th>
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
              </div>
            </div>
          </div>
        </section>
@endsection

@section('scripts')
<script>
        $(document).ready(function() {
        var trendingTweetsDataTable =$('#tweets').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                   url: "{{ route('trending.getTrendingTags') }}",
                   type: 'get',
                    data: function (d) {
                        d.from_date = $("#from_date").val(),
                        d.to_date = $("#to_date").val()
                    }
                },

                "columns": [
                    {
                     "name":"serial_number",
                     "data":"serial_number",
                    },
                    {
                     "name":"tag",
                     "data": "tag" 
                    },
                    { 
                    "name":"users",
                    "data": "users",
                    "render": function (data, type, full, meta) {
                        var usersHtml = '<ul>';
                        data.forEach(function(user) {
                            usersHtml += '<li>' + user.user + ' ( ' + user.posts_count + ' tweet)</li>';
                        });
                        usersHtml += '</ul>';
                        return usersHtml;
                    }
                    },
                    {
                        "name":"posts_count",
                        "data": "posts_count"
                    },
                    {
                        "name":"retweets_count",
                        "data":"retweets_count"
                    }
                ],
               "order": [[ 2, "desc" ]],
                responsive: true,
                processing: true,
                serverSide: true,
                searching: true,
                sorting: true,
                destroy: true,
                info: false,
            });
            // $("#trending-tags-table").css("width","100%");

         $('#submit-search').click(function(){
            console.log("Done");
            //  $('#trending-tags-table').DataTable().draw(true);
             trendingTweetsDataTable.ajax.reload();
            });
        $('#clear-filter').click(function(){
            $('.refresh').val('');
            $('#trending-tags-table').DataTable().draw(true);
        });

        });
    </script>
@endsection