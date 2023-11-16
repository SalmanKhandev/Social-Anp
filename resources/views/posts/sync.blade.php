@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Synchronization</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills" id="myTab3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="syncTab" data-toggle="tab" href="#home3" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fas fa-sync"></i>Sync</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settingTab" data-toggle="tab" href="#profile3" role="tab"
                                aria-controls="profile" aria-selected="false"><i class="fas fa-users-cog"></i>Setting</a>
                        </li>

                </ul>
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="syncTab">
                        {{-- tab integrations content  --}}
                        <div class="card-body">
                            <div class="overflow-ayto">
                                <div id="table-1_wrapper"
                                    class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-header row mt-2">
                                                <div class="col-6">
                                                    <h4>Facebook</h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="overflow-ayto">
                                                    <div id="table-1_wrapper"
                                                        class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                    <a href="#"
                                                                        class="btn btn-icon icon-left syncFacebook btn-primary rounded-sm"
                                                                         type="button">
                                                                        <i class="fas fa-sync"></i> Full Sync Facebook</a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="card-header row mt-2">
                                                <div class="col-6">
                                                    <h4>Twitter</h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="overflow-ayto">
                                                    <div id="table-1_wrapper"
                                                        class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                                        <div class="row">
                                                            <div class="col-12">

                                                                    <a href="#"
                                                                        class="btn btn-icon syncTwitter icon-left btn-primary rounded-sm"
                                                                        type="button" id="syncAdmins"><i
                                                                            class="fas fa-sync"></i>Full Sync Twitter</a>

                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="card-header row mt-2">
                                                <div class="col-6">
                                                    <h4>Instagram</h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="overflow-ayto">
                                                    <div id="table-1_wrapper"
                                                        class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                                        <div class="row">
                                                            <div class="col-12">
                                                               
                                                                    <a href="#" id="syncLevels"
                                                                    class="btn btn-icon icon-left btn-primary rounded-sm" type="button"><i class="fas fa-sync"></i>
                                                                    Full Sync Instagram</a>
                                                             

                                                              
                                     
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- tab 2 --}}
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="settingTab">
                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                <div class="card mt-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>Setting Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            {{-- <div class="mb-3">
                                                <a class="btn btn-danger mr-2" href="export.php?format=pdf">{{__('lang.Export as PDF')}}</a>
                                                <a class="btn btn-primary mr-2" href="export.php?format=csv">{{__('lang.Export as CSV')}}</a>
                                                <a class="btn btn-info" href="export.php?format=excel">{{__('lang.Export as Excel')}}</a>
                                            </div> --}}
                                            {{-- <table id="setting-data" class="table w-100 table-striped table-condensed dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('lang.URL')}}</th>
                                                        <th>{{__('lang.API Key')}}</th>
                                                        <th>{{__('lang.Action')}}</th>
                                                    </tr>
                                                </thead>

                                                <tbody></tbody>

                                            </table> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- tab 3 --}}
                    <div class="tab-pane fade" id="History" role="tabpanel" aria-labelledby="historyTab">
                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                <div class="card mt-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>{{__('lang.Sync History')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            {{-- <div class="mb-3">
                                                <a class="btn btn-danger mr-2" href="export.php?format=pdf">{{__('lang.Export as PDF')}}</a>
                                                <a class="btn btn-primary mr-2" href="export.php?format=csv">{{__('lang.Export as CSV')}}</a>
                                                <a class="btn btn-info" href="export.php?format=excel">{{__('lang.Export as Excel')}}</a>
                                            </div> --}}
                                            <table id="sync-history-data" class="table w-100 table-striped table-condensed dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('lang.Module')}}</th>
                                                        <th>{{__('lang.Sync By')}}</th>
                                                        <th>{{__('lang.Sync Through')}}</th>
                                                        <th>{{__('lang.Sync Type')}}</th>
                                                        <th>{{__('lang.DateTime')}}</th>
                                                    </tr>
                                                </thead>

                                                <tbody></tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- tab 4  --}}
                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">

                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                <div class="card mt-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>{{__('lang.Schedule Details')}}</h4>
                                            <button type="button" class="btn btn-info rounded create-btn" data-toggle="modal"
                                                data-target=".createModel"><i class="fas fa-plus"></i>{{__('lang.Create Schedule')}}</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            {{-- <div class="mb-3">
                                                <a class="btn btn-danger mr-2" href="export.php?format=pdf">{{__('lang.Export as PDF')}}</a>
                                                <a class="btn btn-primary mr-2" href="export.php?format=csv">{{__('lang.Export as CSV')}}</a>
                                                <a class="btn btn-info mr-2" href="export.php?format=excel">{{__('lang.Export as Excel')}}</a>
                                            </div> --}}
                                            <table id="schedule-data" class="table w-100 table-striped table-condensed dt-responsive nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('lang.Task Name')}}</th>
                                                        <th>{{__('lang.Type')}}</th>
                                                        <th>{{__('lang.Day')}}</th>
                                                        <th>{{__('lang.Time')}}</th>
                                                        <th>{{__('lang.Status')}}</th>
                                                        <th>{{__('lang.Action')}}</th>
                                                    </tr>
                                                </thead>

                                                <tbody></tbody>

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
    </div>
</div>


<!-- create schduale modal -->
<div class="modal fade createModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{__('lang.Create Schedule Sync')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form id="create-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card p-3">
                    <div class="form-group">
                        <label>{{__('lang.Enable Schedule Sync')}}</label>
                        <select class="form-control selectric" name="task">
                            <option value="" selected>{{__('lang.Select Task')}}</option>
                           
                        </select>
                        <small class="text-danger" id="error-task"></small>
                    </div>

                    <div class="my-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="dailyRadio" value="daily"
                                checked>
                            <label class="form-check-label" for="dailyRadio">{{__('lang.Daily')}}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="weeklyRadio" value="weekly">
                            <label class="form-check-label" for="weeklyRadio">{{__('lang.Weekly')}}</label>
                        </div>
                        <div class="mt-3" id="timeInput">
                            <label for="time">{{__('lang.Time')}}:</label>
                            <input type="time" id="time" name="time" step="3600" min="00:00" max="23:59"
                                pattern="[0-2][0-9]:[0-5][0-9]">
                        <small class="text-danger" id="error-time"></small>
                        </div>
                        <div class="mt-3" id="daysInput" style="display: none;">
                            <div class="form-group">
                                <label>{{__('lang.Week Days')}}</label>
                                <select class="form-control selectric" name="day">
                                    <option value="1">{{__('lang.Monday')}}</option>
                                    <option value="2">{{__('lang.Tuesday')}}</option>
                                    <option value="3">{{__('lang.Wednesday')}}</option>
                                    <option value="4">{{__('lang.Thursday')}}</option>
                                    <option value="5">{{__('lang.Friday')}}</option>
                                    <option value="6">{{__('lang.Saturday')}}</option>
                                    <option value="0">{{__('lang.Sunday')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                        <button type="submit" class="btn btn-block col-2 btn-primary" id="create-schedule">{{__('lang.Save Schedule')}}</button>

                </div>
              </form>
            </div>
        </div>
    </div>
</div>


<!-- edit schduale modal -->
<div class="modal fade editModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{__('lang.Update Schedule Sync')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form id="update-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="taskId" id="scheduleId">
                <div class="card p-3">
                    <div class="form-group">
                        <label>{{__('lang.Enable Schedule Sync')}}</label>
                        <input class="form-control" readonly type="text" id="task" name="task">
                    </div>

                    <div class="my-3">
                        <div class="form-check">
                            <input type="radio" name="type" id="dailyRadioU"  value="daily">
                            <label for="dailyRadioU">{{__('lang.Daily')}}</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="type" id="weeklyRadioU" value="weekly">
                            <label for="weeklyRadioU">{{__('lang.Weekly')}}</label>
                        </div>
                        <div class="mt-3" id="timeInputU">
                            <label for="time">{{__('lang.Time')}}:</label>
                            <input type="time" id="time" class="time" name="time" step="3600" min="00:00" max="23:59"
                                pattern="[0-2][0-9]:[0-5][0-9]">
                        </div>
                        <div class="mt-3" id="daysInputU" style="display: none;">
                            <div class="form-group">
                                <label>{{__('lang.Week Days')}}</label>
                                <select class="form-control" id="day" name="day">
                                    <option value="1">{{__('lang.Monday')}}</option>
                                    <option value="2">{{__('lang.Tuesday')}}</option>
                                    <option value="3">{{__('lang.Wednesday')}}</option>
                                    <option value="4">{{__('lang.Thursday')}}</option>
                                    <option value="5">{{__('lang.Friday')}}</option>
                                    <option value="6">{{__('lang.Saturday')}}</option>
                                    <option value="0">{{__('lang.Sunday')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                        <button type="submit" class="btn btn-block col-2 btn-primary" id="update-schedule">{{__('lang.Save Schedule')}}</button>

                </div>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- edit setting modal -->
<div class="modal fade settingModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form id="update-setting-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="settingId" id="settingId">
                <div class="card p-3">
                    <div class="form-group">
                        <label>{{__('lang.URL')}}</label>
                        <input class="form-control" type="text" id="url" name="url">
                        <small class="text-danger" id="error_url"></small>
                    </div>
                    <div class="form-group">
                        <label>{{__('lang.API KEY')}}</label>
                        <input class="form-control" type="text" id="api_key" name="api_key">
                        <small class="text-danger" id="error_api_key"></small>
                    </div>

                        <button type="button" class="btn btn-block col-2 btn-primary" id="update-setting">{{__('lang.Save Setting')}}</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>


<!-- sync badge modal -->
<div class="modal fade syncUserLevel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{__('lang.Sync User Levels & Badge')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="settingId" id="settingId">
                <div class="card p-3">
                    <div class="form-group">
                        <label>{{__('lang.Select Game')}}</label>
                        <select name="game" id="selectGame" class="form-control">

                        </select>
                        <small class="text-danger" id="error_game"></small>
                    </div>

                    <button type="button" class="btn btn-block btn-primary" id="syncUserLevels">{{__('lang.Sync User Levels & Badge')}}</button>

                </div>
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


// Sync Facebook Posts 
  $(".syncFacebook").click(function(){
    var url='{{ route("sync.facebook.posts") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Sync Facebook Posts",
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
        data: {},
        beforeSend: function () {
            showLoader()
        },
        success: function(response)
        {
            console.log(response);
            if(response.success){
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



  // Sync Twitter Tweets 
  $(".syncTwitter").click(function(){
    var url='{{ route("sync.twitter.tweets") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Sync Twitter Tweets",
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
        data: {},
        beforeSend: function () {
            showLoader()
        },
        success: function(response)
        {
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
            }else{
                showSwalMessage('error', "Error", response.message)
            }
        },
        complete: function () {
            hideLoader()
        },
    });
    }
    }); 
  });

});




   </script>

@endsection
