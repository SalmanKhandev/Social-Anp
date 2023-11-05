@extends('layouts.master')
@section('content')
    
    
<section>
<div class="container">
    <div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-body text-center">
            <img src="{{auth()->user()->avatar}}" alt="avatar"
            class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{{auth()->user()->name}}</h5>
            <p class="text-muted mb-1">{{auth()->user()->designation}}</p>
            <p class="text-muted mb-4">{{auth()->user()->address}}</p>
            <div class="d-flex justify-content-center mb-2">
            </div>
        </div>
        </div>
        <div class="card mb-4 mb-lg-0">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                <p class="mb-0"><a target="_blank" href="#">{{auth()->user()->name}}</a></p>
            </li>
            </ul>
        </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-4">
        <div class="card-body">
            <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{auth()->user()->name}}</p>
            </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Email</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{auth()->user()->email}}</p>
            </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Phone</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{auth()->user()->contact_number}}</p>
            </div>
            </div>
            <hr>
            <hr>
            <div class="row">
            <div class="col-sm-3">
                <p class="mb-0">Address</p>
            </div>
            <div class="col-sm-9">
                <p class="text-muted mb-0">{{auth()->user()->address}}</p>
            </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 mb-md-0">
            <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Facebook</span> Last Trends Activity
                </p>
                @foreach($groupedPosts as $key=> $post)
                <p class="mb-1" style="font-size: .77rem;">{{$key}}- {{count($post)}}</p>
                <div class="progress rounded" style="height: 5px;">
                <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                 @endforeach
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