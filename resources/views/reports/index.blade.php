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
                <div class="card">
                  <div class="card-header">
                    <h4>Reports</h4>
                  </div>
                  <div class="card-body">
                    <div class="mb-4 row">
                       <div class="form-group col-md-2">
                            {!! Form::label('search_platform_id', 'Platforms') !!}
                            {!! Form::select('query[platform_id]', ['' => __('Select Platform')]+$platforms->pluck('name', 'id')->toArray(), (!is_null($query)) ? $query['platform_id'] : null, ['id' => 'platform_id', 'class' => 'form-control refresh']) !!}
                    </div>
                    <div class="form-group col-md-2">
                            {!! Form::label('search_role_id', 'Users') !!}
                            {!! Form::select('query[user_id]', ['' => __('Select Users')]+$users->pluck('name', 'id')->toArray(), (!is_null($query)) ? $query['user_id'] : null, ['id' => 'user_id', 'class' => 'form-control refresh']) !!}
                    </div>
                    <div class="form-group col-md-2">
                        {!! Form::label('from_date', 'From Date') !!}
                        {!! Form::date('query[from_date]', (!is_null($query)) ? $query['from_date'] : null, ['id' => 'from_date', 'class' => 'form-control refresh']) !!}
                    </div>
                    <div class="form-group col-md-2">
                      {!! Form::label('category', 'Category') !!}
                      {!! Form::select('category', ['' => 'Select Category', 'Personal' => 'Personal', 'Political' => 'Political'], null, ['id' => 'category', 'class' => 'form-control']) !!}
                  </div>
                    
                   <div class="form-group col-md-2">
                      {!! Form::label('Tags', 'Select Tags') !!}
                      {!! Form::select('Tags', ['' => 'Select Hashtags']+$tags->pluck('name','id')->toArray(), null, ['id' => 'tag', 'class' => 'form-control']) !!}
                  </div>


                    <div class="form-group col-md-2">
                        {!! Form::label('to_date', 'To Date') !!}
                        {!! Form::date('query[to_date]', (!is_null($query)) ? $query['to_date'] : null, ['id' => 'to_date', 'class' => 'form-control refresh']) !!}
                    </div>
                    <div class="form-group col-md-2" style="margin-top: 30px;">
                        <a type="button" class="btn btn-success text-white" id="submit-search">Filter</a>
                        <a type="button" class="btn btn-success text-white" id="clear-filter">Clear</a>
                    </div>
                </div>
                    <div class="table-responsive">
                      <table class="table table-striped" id="reports-table">
                        <thead>
                          <tr>
                            <th>User</th>
                            <th>Platform</th>
                            <th>Post ID</th>
                            <th>Category</th>
                            <th>Message</th>
                            <th>Tags</th>
                            <th>Date</th>
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
                    url: "{{route('reports.all')}}",
                    type: 'get',
                    data: function (d) {
                        d.user_id = $("#user_id").val(),
                        d.from_date = $("#from_date").val(),
                        d.to_date = $("#to_date").val()
                        d.platform_id = $("#platform_id").val()
                        d.category = $("#category").val()
                        d.tag = $("#tag").val()
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
                data: 'category',
                name: 'Category'
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
              data:'created_at',
              name:'Date '
            }
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
    
  });
</script>
@endsection