@php
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>User Agreement </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    	body{
    color: #6F8BA4;
    margin-top:20px;
}
.section {
    padding: 100px 0;
    position: relative;
}
.gray-bg {
    background-color: #f5f5f5;
}
img {
    max-width: 100%;
}
img {
    vertical-align: middle;
    border-style: none;
}
/* About Me 
---------------------*/
.about-text h3 {
  font-size: 45px;
  font-weight: 700;
  margin: 0 0 6px;
}
@media (max-width: 767px) {
  .about-text h3 {
    font-size: 35px;
  }
}
.about-text h6 {
  font-weight: 600;
  margin-bottom: 15px;
}
@media (max-width: 767px) {
  .about-text h6 {
    font-size: 18px;
  }
}
.about-text p {
  font-size: 18px;
  max-width: 450px;
}
.about-text p mark {
  font-weight: 600;
  color: #20247b;
}

.about-list {
  padding-top: 10px;
}
.about-list .media {
  padding: 5px 0;
}
.about-list label {
  color: #20247b;
  font-weight: 600;
  width: 88px;
  margin: 0;
  position: relative;
}
.about-list label:after {
  content: "";
  position: absolute;
  top: 0;
  bottom: 0;
  right: 11px;
  width: 1px;
  height: 12px;
  background: #20247b;
  -moz-transform: rotate(15deg);
  -o-transform: rotate(15deg);
  -ms-transform: rotate(15deg);
  -webkit-transform: rotate(15deg);
  transform: rotate(15deg);
  margin: auto;
  opacity: 0.5;
}
.about-list p {
  margin: 0;
  font-size: 15px;
}

@media (max-width: 991px) {
  .about-avatar {
    margin-top: 30px;
  }
}

.about-section .counter {
  padding: 22px 20px;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
}
.about-section .counter .count-data {
  margin-top: 10px;
  margin-bottom: 10px;
}
.about-section .counter .count {
  font-weight: 700;
  color: #20247b;
  margin: 0 0 5px;
}
.about-section .counter p {
  font-weight: 600;
  margin: 0;
}
mark {
    background-image: linear-gradient(rgba(252, 83, 86, 0.6), rgba(252, 83, 86, 0.6));
    background-size: 100% 3px;
    background-repeat: no-repeat;
    background-position: 0 bottom;
    background-color: transparent;
    padding: 0;
    color: currentColor;
}
.theme-color {
    color: #fc5356;
}
.dark-color {
    color: #20247b;
}


    </style>
</head>
<body>
<section class="section about-section gray-bg" id="about">
<div class="container">
<div class="row align-items-center flex-row-reverse">
<div class="col-lg-6">
<div class="about-text go-to">
<h3 class="dark-color">About Me</h3>
<h6 class="theme-color lead">{{auth()->user()->name}}</h6>
<h6 class="theme-color lead" style="color: black;">{{auth()->user()->designation}}</h6>
<p>{{auth()->user()->about}}</p>
<div class="row about-list">
<div class="col-md-6">
<div class="media">
<label>Birthday</label>
<p>4th april 1998</p>
</div>
<div class="media">
<label>DOB</label>
<p>{{auth()->user()->dob}}</p>
</div>
<div class="media">
<label>Residence</label>
<p>{{auth()->user()->residence}}</p>
</div>
<div class="media">
<label>Address</label>
<p>{{auth()->user()->address}}</p>
</div>
</div>
<div class="col-md-6">
<div class="media">
<label>E-mail</label>
<p>{{auth()->user()->email}}</p>
</div>
<div class="media">
<label>Phone</label>
<p>{{auth()->user()->contact_number}}</p>
</div>

<div class="media">
<label>Freelance</label>
<p>Available</p>
</div>
</div>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="about-avatar">
<img src="https://bootdey.com/img/Content/avatar/avatar7.png" title alt>
</div>
</div>
</div>
<div class="counter mt-5">
  <form action="{{route('approve.agreement')}}">
    @csrf
    <div class="row">
 <p style="padding:20px;">Dear {{auth()->user()->name}},
  We kindly request your permission to access your Facebook posts to support our project. Your data will be handled with care and in compliance with privacy regulations. Your contribution is greatly appreciated.</p>
<div class="container text-right">
  <button class="btn btn-danger" name="approval_status" value="declined ">Decline</button>
  <button class="btn btn-success mr-2" name="approval_status" value="approved">Approve</button>
</div>
</div>
  </form>
</div>
</div>
</section>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>