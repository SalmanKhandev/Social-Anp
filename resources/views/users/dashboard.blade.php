@extends('layouts.master')

@section('content')
<section class="section">
<div class="row">
<div class="col-md-5">
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif


@if(auth()->user()->status==0)
<div class="alert alert-primary">
        You are registered successfully please wait until Admin approve your account !
    </div>
@endif
</div>
</div>




@if(!auth()->user()->facebook_connected || !auth()->user()->twitter_connected)
<div class="row">
<div class="col-md-5">
     <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
    <button class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
         Your Social accounts are not connected Please Connect them !
</div>
</div>
</div>
</div>
@endif
<div class="row">
<div class="col-2">
    <a href="{{ url('/auth/facebook') }}" class="btn btn-block btn-social btn-facebook">
        <span class="fab fa-facebook"></span>Connect Facebook
    </a>
    </div>
@if(!auth()->user()->twitter_connected)
<div class="col-2">
<a href="{{route('twitter.user.login')}}" class="btn btn-block btn-social btn-twitter">
    <span class="fab fa-twitter"></span> Connect Twitter
</a>
</div>
@endif
</div>
<br>
<br>
<br>

<div class="row">
<div class="col-md-6 col-lg-12 col-xl-6">
    <!-- Support tickets -->
    <div class="card">
    <div class="card-header">
        <h4>Top Facebook Users</h4>
    </div>
    <div class="card-body">
      
        @foreach ($data['facebook_top_users'] as $user)
        <div class="support-ticket media pb-1 mb-3">
        <img src="https://i.pinimg.com/1200x/7b/8c/d8/7b8cd8b068e4b9f80b4bcf0928d7d499.jpg"  class="user-img mr-2" alt="">
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
    <!-- Support tickets -->
    <div class="card">
    <div class="card-header">
        <h4>Top Twitter Users</h4>
    </div>
    <div class="card-body">
      
        @foreach ($data['twitter_top_users'] as $user)
        <div class="support-ticket media pb-1 mb-3">
        <img src="{{$user->avatar}}"  class="user-img rounded-circle mr-2" alt="">
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
    <h4>Facebook Trending Posts</h4>
    </div>
    <div class="card-body">
    <ul class="list-unstyled list-unstyled-border user-list" id="message-list">
        @foreach($data['facebook_tags']  as $key=> $tag)
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
<div class="col-md-6 col-lg-12 col-xl-6">
<div class="card">
    <div class="card-header">
    <h4>Twitter Trending Tweets</h4>
    </div>
    <div class="card-body">
    <ul class="list-unstyled list-unstyled-border user-list" id="message-list">
        @foreach($data['twitter_tags']  as $key=> $tag)
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