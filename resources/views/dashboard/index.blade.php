@extends('layouts.master')

@section('content')
<section class="section">
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon d-flex justify-content-center align-items-center l-bg-purple">
                    <i class="fab fa-facebook-f"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="padding-20">
                      <div class="text-right">
                        <h3 class="font-light mb-0">
                        <a href="{{route('facebook.posts')}}"><i class="ti-arrow-up text-success"></i>{{$data['facebook']}} </a>
                        </h3>
                    <span class="text-muted">Posts Received</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon d-flex justify-content-center align-items-center" style="background:#1DA1F2;">
                    <i class="fab fa-twitter-square"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="padding-20">
                      <div class="text-right">
                        <h3 class="font-light mb-0">
                          <i class="ti-arrow-up text-success"></i> {{$data['twitter']}}
                        </h3>
                        <span class="text-muted">Tweets</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon instagram-colors d-flex justify-content-center align-items-center" >
                    <i class="fab fa-instagram"></i>

                  </div>
                  <div class="card-wrap">
                    <div class="padding-20">
                      <div class="text-right">
                        <h3 class="font-light mb-0">
                          <i class="ti-arrow-up text-success"></i> {{$data['instagram']}}
                        </h3>
                        <span class="text-muted">Instagram Posts</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon d-flex justify-content-center align-items-center l-bg-orange">
                    <i class="fas fa-users"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="padding-20">
                      <div class="text-right">
                        <h3 class="font-light mb-0">
                          <i class="ti-arrow-up text-success"></i>{{$data['users']}}
                        </h3>
                        <span class="text-muted">All Users</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



<div class="row">
<div class="col-md-6 col-lg-12 col-xl-6">
    <!-- Support tickets -->
    <div class="card">
    <div class="card-header">
        <h4>Top Users</h4>
        <form class="card-header-form">
        <input type="text" name="search" class="form-control" placeholder="Search">
        </form>
    </div>
    <div class="card-body">
      
        @foreach ($data['top_users'] as $user)
        <div class="support-ticket media pb-1 mb-3">
        <img src="{{$user->avatar}}" class="user-img mr-2" alt="">
        <div class="media-body ml-3">
            <div class="badge badge-pill badge-info mb-1 float-right">{{$user->posts_count}}</div>
            <span class="font-weight-bold">{{$user->name}}</span><br>
            <small class="text-muted">Member Since
            &nbsp;&nbsp; {{\Carbon\Carbon::parse($user->created_at)->format('F Y')}}</small>
        </div>
        </div>
        @endforeach

       
    </div>
    </div>
    <!-- Support tickets -->
</div>

<div class="col-md-6 col-lg-12 col-xl-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Trending Posts</h4>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border user-list" id="message-list">
                        @foreach($data['tags']  as $key=> $tag)
                      <li class="media">
                        <div class="media-body">
                          <div class="font-weight-bold">{{$key}}</div>
                          <div class="text-small">{{$tag[0]->posts_count}} Posts </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
</div>

 <div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Posts Statistics</h4>
      </div>
      <div class="card-body">
        <div id="area_chart" class="graph"></div>
      </div>
    </div>
  </div>
</div>
</section>
@endsection

@section('scripts')
<script>
$(function () {
    // Assuming data is already loaded correctly as you mentioned earlier
    getMorris("area", "area_chart");
});

var data = @json($data['chart_data']);

// Define an array of month names from January to December
var allMonths = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

function preprocessData(data) {
    // Create a mapping of months to their corresponding data
    var monthData = {};

    // Initialize the monthData with default values
    for (var i = 0; i < allMonths.length; i++) {
        var month = allMonths[i];
        monthData[month] = { w: month, x: 0, y: 0, z: 0 };
    }

    // Update the monthData with the actual data values
    for (var i = 0; i < data.length; i++) {
       var month = data[i].w;
        monthData[month].x = data[i].x;
        monthData[month].y = data[i].y;
        monthData[month].z = data[i].z;

        console.log(monthData[month]);

    }

    // Convert the monthData object to an array
    var processedData = [];
    for (var i = 0; i < allMonths.length; i++) {
        processedData.push(monthData[allMonths[i]]);
    }

    return processedData;
}

function getMorris(type, element) {
    if (type === "area") {
        var processedData = preprocessData(data);
        Morris.Area({
            element: element,
            data: processedData,
            xkey: "w",
            ykeys: ["x", "y", "z"],
            labels: ["Facebook", "Twitter", "Instagram"],
            xLabels: "w",
            parseTime: false,
            pointSize: 0,
            lineWidth: 0,
            resize: true,
            fillOpacity: 0.8,
            behaveLikeLine: true,
            gridLineColor: "#e0e0e0",
            hideHover: "auto",
            lineColors: [
                "rgb(1, 101, 225)",
                "rgb(29, 155, 240)",
                "rgb(193, 53, 132)",
            ],
        });
    }
}



</script>
@endsection