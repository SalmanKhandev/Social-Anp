@extends('layouts.master')

@section('content')
<section class="section">
<div class="row">
<div class="col-md-6 col-lg-12 col-xl-6">
    <!-- Support tickets -->
    <div class="card">
    <div class="card-header">
        <h4>Top Users</h4>
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


</section>
@endsection

@section('scripts')

@endsection