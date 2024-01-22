@extends('layouts.master')

@section('styles')
<style>
.blue-tag {
    color: blue; /* Set the color to blue or any other desired color */
}
</style>
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h4>Trending Tags</h4>
                  </div>
                  <div class="card-body">
                    <div class="mb-4 row">
                  <div class="form-group col-md-3">
                      {!! Form::label('Tags', 'Select Tags') !!}
                      {!! Form::select('Tags', ['' => 'Select Hashtags']+$tags->pluck('name','id')->toArray(), null, ['id' => 'tag', 'class' => 'form-control refresh']) !!}
                  </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('from_date', 'From Date') !!}
                        {!! Form::date('query[from_date]', (!is_null($query)) ? $query['from_date'] : null, ['id' => 'from_date', 'class' => 'form-control refresh']) !!}
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('to_date', 'To Date') !!}
                        {!! Form::date('query[to_date]', (!is_null($query)) ? $query['to_date'] : null, ['id' => 'to_date', 'class' => 'form-control refresh']) !!}
                    </div>
                    <div class="form-group col-md-3" style="margin-top: 30px;">
                        <a type="button" class="btn btn-success text-white" id="submit-search">Filter</a>
                        <a type="button" class="btn btn-success text-white" id="clear-filter">Clear</a>
                    </div>
                </div>
                    <div class="table-responsive">
                    <table class="table table-striped" id="trending-tags-table" >
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Users</th>
                            <th>Tweets </th>
                            <th>Retweets</th>
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
  <script>
        $(document).ready(function() {
        var trendingTweetsDataTable =$('#trending-tags-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                   url: "{{ route('trending.getTrendingTags') }}",
                   type: 'get',
                    data: function (d) {
                        d.from_date = $("#from_date").val(),
                        d.to_date = $("#to_date").val()
                        d.tag_id  =$("#tag").val();
                    }
                },

                "columns": [
                    {
                     "name":"serial_number",
                     "data":"serial_number",
                    },
                    {
                     "name":"name",
                     "data": "name" 
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