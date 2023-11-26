<!DOCTYPE html>
<html lang="en">


<!-- auth-register.html  21 Nov 2019 04:05:01 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SignUp</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('public/assets/bundles/bootstrap-social/bootstrap-social.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/css/app.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/bundles/jquery-selectric/selectric.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('public/assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href='{{asset('public/assets/img/anp.png')}}' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>
              <div class="card-body">
                @if(session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
                @endif
                <form action="{{route('user.signup')}}" method="POST">
                    @csrf
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="frist_name">Full Name</label>
                      <input id="full_name" required value="{{old('full_name')}}" type="text" class="form-control" name="full_name" >
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">Email</label>
                      <input id="email" required type="text" value="{{old('email')}}" class="form-control" name="email">
                       @error('email')
                            <span class="text-danger">{{ $message }}</span>
                       @enderror
                    </div>
                  </div>
                 <div class="row">
                   <div class="form-group col-6">
                    <label for="email">DOB</label>
                    <input id="dob" required type="date" value="{{old('dob')}}" class="form-control" name="dob">
                     @error('email')
                            <span class="text-danger">{{ $message }}</span>
                     @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                    <div class="form-group col-6">
                    <label for="email">Residence</label>
                    <input id="residence" required type="text" value="{{old('residence')}}" class="form-control" name="residence">
                     @error('residence')
                            <span class="text-danger">{{ $message }}</span>
                     @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                 </div>
                <div class="row">
                   <div class="form-group col-6">
                    <label for="email">Designation</label>
                    <input id="dob" required type="text" class="form-control" value="{{old('designation')}}" name="designation">
                     @error('dob')
                        <span class="text-danger">{{ $message }}</span>
                     @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                    <div class="form-group col-6">
                    <label for="email">Contact Number</label>
                    <input id="contact_number" type="text" class="form-control" value="{{old('contact_number')}}" name="contact_number">
                     @error('contact_number')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                 </div>
                <div class="row">
                   <div class="form-group col-6">
                    <label for="email">Residence</label>
                    <input id="residence" type="text" class="form-control" value="{{old('residence')}}" name="residence">
                     @error('residence')
                            <span class="text-danger">{{ $message }}</span>
                     @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                    <div class="form-group col-6">
                    <label for="email">Address</label>
                    <input id="address" type="text" class="form-control" value="{{old('address')}}" name="address">
                     @error('address')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                 </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" value="{{old('password')}}" class="form-control pwstrength" data-indicator="pwindicator"
                        name="password">
                    @error('password')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" value="{{old('password-confirm')}}" class="form-control" name="password-confirm">
                         @error('password-confirm')
                            <span class="text-danger">{{ $message }}</span>
                         @enderror
                    </div>
                  </div>
                    <div class="form-group ">
                    <label for="email">About</label>
                    <input id="about" type="text" value="{{old('about')}}" class="form-control" name="about">
                      @error('about')
                            <span class="text-danger">{{ $message }}</span>
                      @enderror
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  <div class="form-group">
                     <div class="mb-2 mt-3">
                        <div class="text-small font-weight-bold">Link Your Social Accounts (required)</div>
                      </div>
                      <a href="{{ url('/auth/facebook') }}" class="btn btn-social-icon mr-1 btn-facebook">
                        <i class="fab fa-facebook-f" style="background-color:#1877F2"></i>
                      </a>
                      <a href="{{route('twitter.user.login')}}" class="btn btn-social-icon mr-1 btn-twitter" style="background-color: #1DA1F2;">
                        <i class="fab fa-twitter"></i>
                      </a>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                Already Registered? <a href="{{route('login')}}">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{asset('public/assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('public/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{asset('public/assets/bundles/jquery-selectric/jquery.selectric.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('public/assets/js/page/auth-register.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('public/assets/js/scripts.js')}}"></script>
  <script src="{{asset('public/assets/js/page/widget-data.js')}}"></script>

  <!-- Custom JS File -->
  <script src="{{asset('public/assets/js/custom.js')}}"></script>
</body>


<!-- auth-register.html  21 Nov 2019 04:05:02 GMT -->
</html>