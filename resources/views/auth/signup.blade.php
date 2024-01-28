<!DOCTYPE html>
<html lang="en">


<!-- auth-register.html  21 Nov 2019 04:05:01 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register </title>
  <!-- General CSS Files -->
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
                <h4>Please signUp  to coninue</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{route('user.create.account')}}">
                    {{ csrf_field() }}
                  <div class="row">
                      <div class="form-group col-6">
                      <label for="name" class="d-block">Name</label>
                      <input id="name" required type="text" value="{{old('full_name')}}" class="form-control pwstrength" data-indicator="pwindicator"
                        name="full_name">
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  
                    </div>
                    <div class="form-group col-6">
                      <label for="password2"  class="d-block">Email</label>
                      <input id="password2" required type="email" value="{{old('email')}}" class="form-control" name="email">
                      @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" required type="password" value="{{old('password')}}" class="form-control pwstrength" data-indicator="pwindicator"
                        name="password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                
                    </div>
                    <div class="form-group col-6">
                      <label for="password2"  class="d-block">Password Confirmation</label>
                      <input id="password2" required type="password" value="{{old('password-confirm')}}" class="form-control" name="password-confirm">
                        @error('password-confirm')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                      <div class="form-group col-6">
                      <label for="password2" required class="d-block">Contact Number</label>
                      <input id="password2" required type="text" value="{{old('contact_number')}}" class="form-control" name="contact_number">
                        @error('contact_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                      <div class="form-group col-6">
                      <label for="password2" required class="d-block">Designation</label>
                      {{-- <input id="password2" required type="text" value="{{old('designation')}}" class="form-control" name="designation"> --}}
                          <select class="form-control" name="designation" id="designation" required>
                          <option value="">Select Designation</option>
                          <option value="District Social Media Coordinator">District Social Media Coordinator</option>
                          <option value="Deputy district Social Media Coordinator">Deputy district Social Media Coordinator</option>
                          <option value="Tehsil Social Media Coordinator">Tehsil Social Media Coordinator</option>
                          <option value="Deputy Tehsil Social media Coordinator">Deputy Tehsil Social media Coordinator</option>
                          <option value="VC Social media Coordinator">VC Social media Coordinator</option>
                          <option value="Deputy VC Social Media Coordinator">Deputy VC Social Media Coordinator</option>
                          <option value="Candidate Volunteer">Candidate Volunteer</option>
                          <option value="General Volunteer">General Volunteer</option>
                        </select>
                       @error('designation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                     <div class="form-group col-6">
                      <label for="password2" required class="d-block">DOB</label>
                      <input id="date" required type="date" value="{{old('dob')}}" class="form-control" name="dob">
                         @error('dob')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                     <div class="form-group col-6">
                      <label for="password2"  class="d-block">District</label>
                      <select class="form-control" required name="district">
                      <option value="">Select District</option>
                      <option value="ABBOTTABAD">ABBOTTABAD</option>
                      <option value="BAJAUR">BAJAUR</option>
                      <option value="BANNU">BANNU</option>
                      <option value="BATAGRAM">BATAGRAM</option>
                      <option value="BUNER">BUNER</option>
                      <option value="CHARSDADDA">CHARSDADDA</option>
                      <option value="DERA ISMAIL KHAN">DERA ISMAIL KHAN</option>
                      <option value="HANGU">HANGU</option>
                      <option value="HARIPUR">HARIPUR</option>
                      <option value="KARAK">KARAK</option>
                      <option value="KHYBER">KHYBER</option>
                      <option value="KOLAI PALAS">KOLAI PALAS</option>
                      <option value="KOHAT">KOHAT</option>
                      <option value="KURRAM">KURRAM</option>
                      <option value="LAKKI MARWAT">LAKKI MARWAT</option>
                      <option value="LOWER CHITRAL">LOWER CHITRAL</option>
                      <option value="LOWER DIR">LOWER DIR</option>
                      <option value="MALAKAND">MALAKAND</option>
                      <option value="MARDAN">MARDAN</option>
                      <option value="MANSEHRA">MANSEHRA</option>
                      <option value="MOHMAND">MOHMAND</option>
                      <option value="NORTH WAZIRISTAN">NORTH WAZIRISTAN</option>
                      <option value="NOWSHERA">NOWSHERA</option>
                      <option value="ORAKZAI">ORAKZAI</option>
                      <option value="PESHAWAR">PESHAWAR</option>
                      <option value="SHANGLA">SHANGLA</option>
                      <option value="SOUTH WAZIRISTAN">SOUTH WAZIRISTAN</option>
                      <option value="SWAT">SWAT</option>
                      <option value="TANK">TANK</option>
                      <option value="TORGHAR">TORGHAR</option>
                      <option value="UPPER CHITRAL">UPPER CHITRAL</option>
                      <option value="UPPER DIR">UPPER DIR</option>
                      <option value="UPPER KOHISTAN">UPPER KOHISTAN</option>
                      <option value="FATA">FATA</option>
            
                  </select>
                       @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                  <div class="row">
                  <div class="form-group col-4">
                      <label for="password2" required class="d-block">Tehsil</label>
                      <input id="password2" required type="text" value="{{old('tehsil')}}" class="form-control" name="tehsil">
                        @error('tehsil')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                   <div class="form-group col-4">
                      <label for="password2" required class="d-block">Village Council</label>
                      <input id="password2" required type="text" value="{{old('village_council')}}" class="form-control" name="village_council">
                        @error('village_council')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                   <div class="form-group col-4">
                      <label for="password2" required class="d-block">Constituency (Halqa)</label>
                      <input id="password2" required type="text" value="{{old('constituency')}}" class="form-control" name="constituency">
                        @error('constituency')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                   <div class="form-group col-12">
                      <label for="password2" required class="d-block">Candidate Name</label>
                      <input required name="candidate_name" id="" value="{{old('candidate_name')}}" cols="30" rows="10" class="form-control"/>
                        @error('candidate_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                  </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
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
  <!-- Custom JS File -->
  <script src="{{asset('public/assets/js/custom.js')}}"></script>
</body>


<!-- auth-register.html  21 Nov 2019 04:05:02 GMT -->
</html>