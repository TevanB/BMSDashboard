<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Elo Boosting & Professional LOL Boosting - BMSBoosting.com</title>
    <link rel="icon" href="https://app.bmsboosting.com/img/logo.png">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Styles -->
    <link href="dist/css/component-custom-switch.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" id="avada-stylesheet-css" href="https://www.bmsboosting.com/wp-content/themes/Avada/assets/css/style.min.css?ver=5.7.1" type="text/css" media="all">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bd-wizard.css">
    <link rel="stylesheet" href="assets/css/stripestyling.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>

    <style>
      .chat {
        list-style: none;
        margin: 0;
        padding: 0;
      }

      .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
      }

      .chat li .chat-body p {
        margin: 0;
        color: #777777;
      }

      .panel-body {
        overflow-y: scroll;
        height: 350px;
      }

      ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
      }

      ::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
      }

      ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
      }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bggrey shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="https://bmsboosting.com">
                    <img src="/img/profile/profile.png" width="197" height="180" alt="BMS Boosting Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="fas fa-bars white"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item ml-2 mr-2">
                            <a class="nav-link text-light menuFont" href="https://bmsboosting.com">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light menuFont" href="https://app.bmsboosting.com/boosting">{{ __('LoL Boosting') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light menuFont" href="https://bmsboosting.com/tft-elo-boosting">{{ __('TFT Boosting') }}</a>
                        </li>
                        <li class="nav-item ml-2 mr-2">
                            <a class="nav-link text-light menuFont" href="https://bmsboosting.com/coaching">Coaching</a>
                        </li>
                        <li class="nav-item ml-2 mr-2">
                            <a class="nav-link text-light menuFont" href="https://bmsboosting.com/account-selling">Accounts</a>
                        </li>


                        <li class="nav-item dropdown ml-2 mr-2">
                            <a id="navbarDropdown" class="nav-link text-light dropdown-toggle menuFont" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Help Centre<span class="caret"></span></a>
                            <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-light menuFont" href="https://bmsboosting.com/team">
                                  Team
                                </a>

                                <a class="dropdown-item text-light menuFont" href="https://bmsboosting.com/tos">
                                    Terms of Service
                                </a>
                                <a class="dropdown-item text-light menuFont" href="https://bmsboosting.com/faq">
                                    F.A.Q.
                                </a>
                                <a class="dropdown-item text-light menuFont" href="https://bmsboosting.com/contact-us">
                                    Contact Us
                                </a>
                                <a class="dropdown-item text-light menuFont" href="https://bmsboosting.com/booster-applications">
                                    Join Our Team
                                </a>
                            </div>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-light menuFont" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-light menuFont mr-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light menuFont" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-light menuFont" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <li class="nav-item">
                          <a href="https://bmsboosting.com/cart">
                          <i class="fas fa-shopping-cart white align-bottom ml-4 mr-4"></i>
                          </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="d-flex bggrey">
          <div class="container-fluid">
          <div class="row align-items-center justify-content-center carBack">
            <div id="carouselExampleSlidesOnly" class="carousel slide mt-5 mb-5" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h1 class="font-weight-bold text-center h1 my-5 text-light">New LoL ELO Boosting Experience</h1>
                </div>

              </div>
            </div>
          </div>
          <div class="row align-items-center greyBG1">
            <div class="row container-fluid">
              <div class="col-1"></div>
              <div class="col align-items-center  mt-5">
                <div class="row">
                <div class="col-10">

                  <div class="container mt-5">

                    <div id="wizard" class="mb-5">
                    <h3>Step 1 Title</h3>
                    <section>
                     <h2 class="section-heading text-center mb-3 text-light">Select Solo or Duo</h2>
                     <div class="purpose-radios-wrapper text-center" id="solo-duo-input">
                        <div class="purpose-radio">
                            <input type="radio" name="solo-duo" id="solo" class="purpose-radio-input" value="Solo" selected="unselected">
                           <label for="solo" class="purpose-radio-label bg-light border">
                             <span class="label-icon">
                               <i class="fas fa-user label-icon-default" alt="solo-division-icon"></i>
                               <i class="fas fa-user label-icon-active" alt="solo-division-icon"></i>
                             </span>
                             <span class="label-text">Solo</span>
                           </label>
                          </div>
                          <div class="purpose-radio">
                             <input type="radio" name="solo-duo" id="duo" class="purpose-radio-input" value="Duo" selected="unselected">
                            <label for="duo" class="purpose-radio-label bg-light border">
                              <span class="label-icon">
                                <i class="fas fa-user-friends label-icon-default" alt="duo-division-icon"></i>
                                <i class="fas fa-user-friends label-icon-active" alt="duo-division-icon"></i>
                              </span>
                              <span class="label-text">Duo</span>
                            </label>
                           </div>

                     </div>

                    </section>
                    <h3>Step 2 Title</h3>
                    <section>
                      <h2 class="section-heading text-center mb-3 text-light">Select Order Type</h2>
                      <div id='solo-orders'>
                        <div class="purpose-radios-wrapper text-center">
                           <div class="purpose-radio">
                               <input type="radio" name="solo-type" id="solo-division" class="purpose-radio-input" value="Solo Division">
                              <label for="solo-division" class="purpose-radio-label bg-light border">

                                <span class="label-text text-center">Solo Division Boost</span>
                              </label>
                             </div>
                             <div class="purpose-radio">
                                <input type="radio" name="solo-type" id="solo-net" class="purpose-radio-input" value="Solo Net Wins">
                               <label for="solo-net" class="purpose-radio-label bg-light border">

                                 <span class="label-text text-center">Solo Net Win Boost</span>
                               </label>
                              </div>
                              <div class="purpose-radio">
                                 <input type="radio" name="solo-type" id="solo-placement" class="purpose-radio-input" value="Solo Placement">
                                <label for="solo-placement" class="purpose-radio-label bg-light border">

                                  <span class="label-text text-center">Solo Placements Boost</span>
                                </label>
                               </div>

                        </div>
                      </div>
                      <div id='duo-orders'>
                        <div class="purpose-radios-wrapper text-center">
                           <div class="purpose-radio">
                               <input type="radio" name="duo-type" id="duo-division" class="purpose-radio-input" value="Duo Division">
                              <label for="duo-division" class="purpose-radio-label bg-light border">

                                <span class="label-text text-center">Duo Division Boost</span>
                              </label>
                             </div>
                             <div class="purpose-radio">
                                <input type="radio" name="duo-type" id="duo-net" class="purpose-radio-input" value="Duo Net Wins">
                               <label for="duo-net" class="purpose-radio-label bg-light border">

                                 <span class="label-text text-center">Duo Net Win Boost</span>
                               </label>
                              </div>
                              <div class="purpose-radio">
                                 <input type="radio" name="duo-type" id="duo-placement" class="purpose-radio-input" value="Duo Placement">
                                <label for="duo-placement" class="purpose-radio-label bg-light border">

                                  <span class="label-text text-center">Duo Placements Boost</span>
                                </label>
                               </div>

                        </div>
                      </div>
                      </section>
                    <h3>Step 3 Title</h3>
                    <section>
                      <div id="division-solo">
                        <h2 class="section-heading text-center mb-3 text-light">Select Divisions</h2>
                        <div class="row justify-content-start">
                          <div class="col-sm-6 text-center">
                            <div id="iron-icon-1">
                              <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                            </div>
                            <div id="bronze-icon-1">
                              <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                            </div>
                            <div id="silver-icon-1">
                              <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                            </div>
                            <div id="gold-icon-1">
                              <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                            </div>
                            <div id="platinum-icon-1">
                              <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                            </div>
                            <div id="diamond-icon-1">
                              <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                            </div>
                            <div id="master-icon-1">
                              <img src="assets/images/master.png" alt="master-division" class="label-icon">
                            </div>
                            <div id="grandmaster-icon-1">
                              <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                            </div>
                            <div id="challenger-icon-1">
                              <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                            </div>
                          </div>
                          <div class="col-sm-6 text-center">
                            <div id="iron-icon-2">
                              <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                            </div>
                            <div id="bronze-icon-2">
                              <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                            </div>
                            <div id="silver-icon-2">
                              <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                            </div>
                            <div id="gold-icon-2">
                              <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                            </div>
                            <div id="platinum-icon-2">
                              <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                            </div>
                            <div id="diamond-icon-2">
                              <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                            </div>
                            <div id="master-icon-2">
                              <img src="assets/images/master.png" alt="master-division" class="label-icon">
                            </div>
                            <div id="grandmaster-icon-2">
                              <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                            </div>
                            <div id="challenger-icon-2">
                              <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                            </div>                    </div>
                        </div>
                        <div class="row" id="rankSelect">
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light" for="rank-1">Current Rank</label>

                              <select class="custom-select bg-light" name="rank-1" id="rank-1">
                                <option value="I" selected="selected">Iron</option>
                                <option value="B">Bronze</option>
                                <option value="S">Silver</option>
                                <option value="G">Gold</option>
                                <option value="P">Platinum</option>
                                <option value="D">Diamond</option>
                                <option value="M">Master</option>
                                <option value="GM">Grandmaster</option>
                                <option value="C">Challenger</option>

                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="rank-2">Desired Rank</label>
                              <select class="custom-select bg-light" name="rank-2" id="rank-2">
                                <option value="I">Iron</option>
                                <option value="B" selected="selected">Bronze</option>
                                <option value="S">Silver</option>
                                <option value="G">Gold</option>
                                <option value="P">Platinum</option>
                                <option value="D">Diamond</option>
                                <option value="M">Master</option>
                                <option value="GM">Grandmaster</option>
                                <option value="C">Challenger</option>

                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="division-1">Current Division</label>
                              <select class="custom-select bg-light" id="division-1">
                                <option value="4" selected="selected">Division 4</option>
                                <option value="3">Division 3</option>
                                <option value="2">Division 2</option>
                                <option value="1">Division 1</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="division-2">Desired Division</label>
                              <select class="custom-select bg-light" id="division-2">
                                <option value="4" selected="selected">Division 4</option>
                                <option value="3">Division 3</option>
                                <option value="2">Division 2</option>
                                <option value="1">Division 1</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="startinglp_1">Current LP</label>
                              <select class="custom-select bg-light" id="startinglp_1">
                                <option value="0" selected="selected">0-20</option>
                                <option value="21">21-40</option>
                                <option value="41">41-60</option>
                                <option value="61">61-80</option>
                                <option value="81">81-99</option>
                                <option value="100">100</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="lpg-1">LP Gains</label>
                              <select class="custom-select bg-light" id="lpg_1">
                                <option value="19" selected="selected">19 Or Higher</option>
                                <option value="16">16 to 18</option>
                                <option value="15">15 Or Lower</option>

                              </select>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div id="division-duo">
                        <h2 class="section-heading text-center mb-3 text-light">Select Divisions</h2>
                        <div class="row">
                          <div class="col-sm-6 text-center">
                            <div id="iron-icon-10">
                              <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                            </div>
                            <div id="bronze-icon-10">
                              <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                            </div>
                            <div id="silver-icon-10">
                              <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                            </div>
                            <div id="gold-icon-10">
                              <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                            </div>
                            <div id="platinum-icon-10">
                              <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                            </div>
                            <div id="diamond-icon-10">
                              <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                            </div>
                            <div id="master-icon-10">
                              <img src="assets/images/master.png" alt="master-division" class="label-icon">
                            </div>
                            <div id="grandmaster-icon-10">
                              <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                            </div>
                            <div id="challenger-icon-10">
                              <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                            </div>
                          </div>
                          <div class="col-sm-6 text-center">
                            <div id="iron-icon-11">
                              <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                            </div>
                            <div id="bronze-icon-11">
                              <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                            </div>
                            <div id="silver-icon-11">
                              <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                            </div>
                            <div id="gold-icon-11">
                              <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                            </div>
                            <div id="platinum-icon-11">
                              <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                            </div>
                            <div id="diamond-icon-11">
                              <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                            </div>
                            <div id="master-icon-11">
                              <img src="assets/images/master.png" alt="master-division" class="label-icon">
                            </div>
                            <div id="grandmaster-icon-11">
                              <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                            </div>
                            <div id="challenger-icon-11">
                              <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                            </div>
                          </div>

                        </div>
                        <div class="row" id="rankSelect">
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="rank-10">Current Rank</label>
                              <select class="custom-select bg-light" name="rank-10" id="rank-10">
                                <option value="I" selected="selected">Iron</option>
                                <option value="B">Bronze</option>
                                <option value="S">Silver</option>
                                <option value="G">Gold</option>
                                <option value="P">Platinum</option>
                                <option value="D">Diamond</option>
                                <option value="M">Master</option>
                                <option value="GM">Grandmaster</option>
                                <option value="C">Challenger</option>

                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="rank-11">Desired Rank</label>
                              <select class="custom-select bg-light" namee="rank-11" id="rank-11">
                                <option value="I">Iron</option>
                                <option value="B" selected="selected">Bronze</option>
                                <option value="S">Silver</option>
                                <option value="G">Gold</option>
                                <option value="P">Platinum</option>
                                <option value="D">Diamond</option>
                                <option value="M">Master</option>
                                <option value="GM">Grandmaster</option>
                                <option value="C">Challenger</option>

                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="division-10">Current Division</label>
                              <select class="custom-select bg-light" id="division-10">
                                <option value="4" selected="selected">Division 4</option>
                                <option value="3">Division 3</option>
                                <option value="2">Division 2</option>
                                <option value="1">Division 1</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="division-11">Desired Division</label>
                              <select class="custom-select bg-light" id="division-11">
                                <option value="4" selected="selected">Division 4</option>
                                <option value="3">Division 3</option>
                                <option value="2">Division 2</option>
                                <option value="1">Division 1</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="startinglp-10">Current LP</label>
                              <select class="custom-select bg-light" id="startinglp_10">
                                <option value="0" selected="selected">0-20</option>
                                <option value="21">21-40</option>
                                <option value="41">41-60</option>
                                <option value="61">61-80</option>
                                <option value="81">81-99</option>
                                <option value="100">100</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">

                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">

                          </div>
                          <div class="col-sm-6">
                            <div class="form-group text-center">
                              <label class="text-light"  for="lpg_10">LP Gains</label>
                              <select class="custom-select bg-light" id="lpg_10">
                                <option value="19" selected="selected">19 Or Higher</option>
                                <option value="16">16 to 18</option>
                                <option value="15">15 Or Lower</option>

                              </select>
                            </div>
                          </div>
                          <div class="col-sm-3">

                          </div>
                        </div>
                      </div>
                      <div id="netwin-solo">
                        <h2 class="section-heading text-center mb-3 text-light">Select Net Wins</h2>
                          <div class="row align-items-center">
                            <div class="col">
                              <div class="row">
                                <div>
                                  <div id="iron-icon-3">
                                    <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                                  </div>
                                  <div id="bronze-icon-3">
                                    <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                                  </div>
                                  <div id="silver-icon-3">
                                    <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                                  </div>
                                  <div id="gold-icon-3">
                                    <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                                  </div>
                                  <div id="platinum-icon-3">
                                    <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                                  </div>
                                  <div id="diamond-icon-3">
                                    <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                                  </div>
                                  <div id="master-icon-3">
                                    <img src="assets/images/master.png" alt="master-division" class="label-icon">
                                  </div>
                                  <div id="grandmaster-icon-3">
                                    <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                                  </div>
                                  <div id="challenger-icon-3">
                                    <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                                  </div>
                                </div>
                              </div>


                              </div>

                              <div class="col">
                                <div class="row">
                                <div class="row container-fluid" id="rankSelect">
                                  <div class="container-fluid">

                                    <div class="form-group container-fluid text-center">
                                      <label class="text-light"  for="rank-3">Current Rank</label>
                                      <select class="custom-select bg-light" name="rank-3" id="rank-3">
                                        <option value="I" selected="selected">Iron</option>
                                        <option value="B">Bronze</option>
                                        <option value="S">Silver</option>
                                        <option value="G">Gold</option>
                                        <option value="P">Platinum</option>
                                        <option value="D">Diamond</option>
                                        <option value="M">Master</option>
                                        <option value="GM">Grandmaster</option>
                                        <option value="C">Challenger</option>

                                      </select>



                                    </div>
                                  </div>
                                </div>
                                <div class="row container-fluid">
                                  <div class="container-fluid">
                                  <div class="form-group container-fluid text-center">
                                    <label class="text-light"  for="division-3">Current Division</label>
                                    <select class="custom-select bg-light" id="division-3">
                                      <option value="4" selected="selected">Division 4</option>
                                      <option value="3">Division 3</option>
                                      <option value="2">Division 2</option>
                                      <option value="1">Division 1</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-10">
                          <label class="text-light"  for="net-selector">Number of Net Wins</label>
                          <input type="range" class="custom-range" id="net-selector" value="1" min="1" max="8" step="1">
                        </div>
                        <div class="col-sm-2">
                          <div class="card border-primary mb-3" style="max-width: 18rem;">

                            <div class="card-body text-white bg-light text-center">
                              <h5 class="card-title text-dark" id="net-number-solo">1</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
                      <div id="netwin-duo">
                        <h2 class="section-heading text-center mb-3 text-light">Select Net Wins</h2>
                          <div class="row align-items-center">
                            <div class="col">
                              <div class="row">
                                <div>
                                  <div id="iron-icon-4">
                                    <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                                  </div>
                                  <div id="bronze-icon-4">
                                    <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                                  </div>
                                  <div id="silver-icon-4">
                                    <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                                  </div>
                                  <div id="gold-icon-4">
                                    <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                                  </div>
                                  <div id="platinum-icon-4">
                                    <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                                  </div>
                                  <div id="diamond-icon-4">
                                    <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                                  </div>
                                  <div id="master-icon-4">
                                    <img src="assets/images/master.png" alt="master-division" class="label-icon">
                                  </div>
                                  <div id="grandmaster-icon-4">
                                    <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                                  </div>
                                  <div id="challenger-icon-4">
                                    <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                                  </div>
                                </div>
                              </div>


                              </div>

                              <div class="col">
                                <div class="row">
                                <div class="row container-fluid" id="rankSelect">
                                  <div class="container-fluid">

                                    <div class="form-group container-fluid text-center">
                                      <label class="text-light"  for="rank-4">Current Rank</label>
                                      <select class="custom-select bg-light" name="rank-4" id="rank-4">
                                        <option value="I" selected="selected">Iron</option>
                                        <option value="B">Bronze</option>
                                        <option value="S">Silver</option>
                                        <option value="G">Gold</option>
                                        <option value="P">Platinum</option>
                                        <option value="D">Diamond</option>
                                        <option value="M">Master</option>
                                        <option value="GM">Grandmaster</option>
                                        <option value="C">Challenger</option>

                                      </select>



                                    </div>
                                  </div>
                                </div>
                                <div class="row container-fluid">
                                  <div class="container-fluid">
                                  <div class="form-group container-fluid text-center">
                                    <label class="text-light"  for="division-4">Current Division</label>

                                    <select class="custom-select bg-light" id="division-4">
                                      <option value="4" selected="selected">Division 4</option>
                                      <option value="3">Division 3</option>
                                      <option value="2">Division 2</option>
                                      <option value="1">Division 1</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-10">
                          <label class="text-light"  for="net-selector">Number of Net Wins</label>
                          <input type="range" class="custom-range" id="net-selector-duo" value="1" min="1" max="8" step="1">
                        </div>
                        <div class="col-sm-2">
                          <div class="card border-primary mb-3" style="max-width: 18rem;">

                            <div class="card-body text-white bg-light text-center ">
                              <h5 class="card-title text-dark" id="net-number-duo">1</h5>
                            </div>
                          </div>
                        </div>
                      </div>


                      </div>
                      <div id="placement-solo">
                        <h2 class="section-heading text-center mb-3 text-light">Select Placements</h2>
                          <div class="row align-items-center">
                            <div class="col">
                              <div class="row">
                                <div>
                                  <div id="iron-icon-5">
                                    <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                                  </div>
                                  <div id="bronze-icon-5">
                                    <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                                  </div>
                                  <div id="silver-icon-5">
                                    <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                                  </div>
                                  <div id="gold-icon-5">
                                    <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                                  </div>
                                  <div id="platinum-icon-5">
                                    <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                                  </div>
                                  <div id="diamond-icon-5">
                                    <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                                  </div>
                                  <div id="master-icon-5">
                                    <img src="assets/images/master.png" alt="master-division" class="label-icon">
                                  </div>
                                  <div id="grandmaster-icon-5">
                                    <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                                  </div>
                                  <div id="challenger-icon-5">
                                    <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                                  </div>
                                </div>
                              </div>


                              </div>

                              <div class="col">
                                <div class="row">
                                <div class="row container-fluid" id="rankSelect">
                                  <div class="container-fluid">

                                    <div class="form-group container-fluid text-center">
                                      <label class="text-light"  for="rank-5">Last Season Rank</label>

                                      <select class="custom-select bg-light" name="rank-5" id="rank-5">
                                        <option value="I" selected="selected">Iron</option>
                                        <option value="B">Bronze</option>
                                        <option value="S">Silver</option>
                                        <option value="G">Gold</option>
                                        <option value="P">Platinum</option>
                                        <option value="D">Diamond</option>
                                        <option value="M">Master</option>
                                        <option value="GM">Grandmaster</option>
                                        <option value="C">Challenger</option>

                                      </select>



                                    </div>
                                  </div>
                                </div>

                            </div>
                          </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-10">
                          <label class="text-light"  for="placement-selector-solo">Number of Placement Games</label>
                          <input type="range" class="custom-range" id="placement-selector-solo" value="1" min="1" max="10" step="1">
                        </div>
                        <div class="col-sm-2">
                          <div class="card border-primary mb-3" style="max-width: 18rem;">

                            <div class="card-body text-white bg-light text-center align-self-center">
                              <h5 class="card-title text-dark text-center" id="placement-number-solo">1</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>

                      <div id="placement-duo">
                        <h2 class="section-heading text-center mb-3 text-light">Select Placements</h2>
                          <div class="row align-items-center">
                            <div class="col">
                              <div class="row">
                                <div>
                                  <div id="iron-icon-6">
                                    <img src="assets/images/iron.png" alt="iron-division" class="label-icon">
                                  </div>
                                  <div id="bronze-icon-6">
                                    <img src="assets/images/bronze.png" alt="bronze-division" class="label-icon">
                                  </div>
                                  <div id="silver-icon-6">
                                    <img src="assets/images/silver.png" alt="silver-division" class="label-icon">
                                  </div>
                                  <div id="gold-icon-6">
                                    <img src="assets/images/gold.png" alt="gold-division" class="label-icon">
                                  </div>
                                  <div id="platinum-icon-6">
                                    <img src="assets/images/platinum.png" alt="platinum-division" class="label-icon">
                                  </div>
                                  <div id="diamond-icon-6">
                                    <img src="assets/images/diamond.png" alt="diamond-division" class="label-icon">
                                  </div>
                                  <div id="master-icon-6">
                                    <img src="assets/images/master.png" alt="master-division" class="label-icon">
                                  </div>
                                  <div id="grandmaster-icon-6">
                                    <img src="assets/images/grandmaster.png" alt="grandmaster-division" class="label-icon">
                                  </div>
                                  <div id="challenger-icon-6">
                                    <img src="assets/images/challenger.png" alt="challenger-division" class="label-icon">
                                  </div>
                                </div>
                              </div>


                              </div>

                              <div class="col">
                                <div class="row">
                                <div class="row container-fluid" id="rankSelect">
                                  <div class="container-fluid">

                                    <div class="form-group container-fluid text-center">
                                      <label class="text-light"  for="rank-6">Last Season Rank</label>
                                      <select class="custom-select bg-light" name="rank-6" id="rank-6">
                                        <option value="I" selected="selected">Iron</option>
                                        <option value="B">Bronze</option>
                                        <option value="S">Silver</option>
                                        <option value="G">Gold</option>
                                        <option value="P">Platinum</option>
                                        <option value="D">Diamond</option>
                                        <option value="M">Master</option>
                                        <option value="GM">Grandmaster</option>
                                        <option value="C">Challenger</option>

                                      </select>



                                    </div>
                                  </div>
                                </div>

                            </div>
                          </div>

                      </div>
                      <div class="row">

                        <div class="col-sm-10">
                          <label class="text-light"  for="placement-selector-duo">Number of Placement Games</label>
                          <input type="range" class="custom-range" id="placement-selector-duo" value="1" min="1" max="10" step="1">
                        </div>
                        <div class="col-sm-2">
                          <div class="card border-primary mb-3" style="max-width: 18rem;">

                            <div class="card-body text-white bg-light text-center ">
                              <h5 class="card-title text-dark" id="placement-number-duo">1</h5>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>

                    </section>

                    <h3>Step 4 Title</h3>
                    <section>

                    <h2 class="section-heading mb-5 text-center text-light">Customize Your Order</h2>
                    <div id="solo-options">
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col-6">
                          <h5 class="text-bold text-light">Offline Mode (+10%)</h5>
                        </div>
                        <div class="col-3">
                          <div class="custom-switch custom-switch-label-yesno">
                            <input class="custom-switch-input" id="offline-mode-1" type="checkbox">
                            <label class="custom-switch-btn" for="offline-mode-1"></label>
                            <div class="custom-switch-content-checked">
                            </div>
                            <div class="custom-switch-content-unchecked">
                            </div>
                          </div>
                        </div>
                        <div class="col-2"></div>
                      </div>
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col-6">
                          <h5 class="text-bold text-light">Express Order (+25%)</h5>
                        </div>
                        <div class="col-3">
                          <div class="custom-switch custom-switch-label-yesno">
                            <input class="custom-switch-input" id="express-order-1" type="checkbox">
                            <label class="custom-switch-btn" for="express-order-1"></label>
                            <div class="custom-switch-content-checked">
                            </div>
                            <div class="custom-switch-content-unchecked">
                            </div>
                          </div>
                        </div>
                        <div class="col-2"></div>
                      </div>

                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col-6">
                          <h5 class="text-bold text-light">Server (Required)</h5>
                        </div>
                        <div class="col">
                          <select class="custom-select bg-light" name="regionSel" id="regionSel">
                            <option value="na" selected="selected">NA</option>
                            <option value="euw">EUW</option>
                            <option value="eune">EUNE</option>
                            <option value="oce">OCE</option>
                            <option value="lan">LAN</option>
                            <option value="las">LAS</option>
                            <option value="br">BR</option>
                            <option value="jp">JP</option>
                            <option value="tr">TR</option>
                            <option value="ru">RU</option>
                          </select>
                        </div>
                        <div class="col-2"></div>
                      </div>

                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col-6">
                          <h5 class="text-bold text-light">Primary Role (Complimentary)</h5>
                        </div>
                        <div class="col">
                          <select class="custom-select bg-light" name="primary_role" id="primary_role">
                            <option value="Top" selected="selected">Top</option>
                            <option value="Jungle">Jungle</option>
                            <option value="Mid">Mid</option>
                            <option value="ADC">ADC</option>
                            <option value="Support">Support</option>
                          </select>
                        </div>
                        <div class="col-2"></div>
                      </div>
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col-6">
                          <h5 class="text-bold text-light">Secondary Role (Complimentary)</h5>
                        </div>
                        <div class="col">
                          <select class="custom-select bg-light" name="secondary_role" id="secondary_role">
                            <option value="Top">Top</option>
                            <option value="Jungle" selected="selected">Jungle</option>
                            <option value="Mid">Mid</option>
                            <option value="ADC">ADC</option>
                            <option value="Support">Support</option>
                          </select>
                        </div>
                        <div class="col-2"></div>
                      </div>
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col-6">
                          <h5 class="text-bold text-light">Preffered Keyset (Complimentary)</h5>
                        </div>
                        <div class="col">
                          <select class="custom-select bg-light" name="keyset" id="keyset">
                            <option value="Flash on F" selected="selected">Flash on F</option>
                            <option value="Flash on D">Flash on D</option>


                          </select>
                        </div>
                        <div class="col-2"></div>
                      </div>
                    </div>
                    <div id="duo-options">

                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col">
                          <h5 class="text-bold text-light">Express Order (+25%)</h5>
                        </div>
                        <div class="col-3 d-flex justify-content-center">
                          <div class="custom-switch custom-switch-label-yesno">
                            <input class="custom-switch-input" id="express-order-2" type="checkbox">
                            <label class="custom-switch-btn" for="express-order-2"></label>
                            <div class="custom-switch-content-checked">
                            </div>
                            <div class="custom-switch-content-unchecked">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col">
                          <h5 class="text-bold text-light">Server (Required)</h5>
                        </div>
                        <div class="col-3">
                          <select class="custom-select bg-light" name="regionSel2" id="regionSel2">
                            <option value="na" selected="selected">NA</option>
                            <option value="euw">EUW</option>
                            <option value="eune">EUNE</option>
                            <option value="oce">OCE</option>
                            <option value="lan">LAN</option>
                            <option value="las">LAS</option>
                            <option value="br">BR</option>
                            <option value="jp">JP</option>
                            <option value="tr">TR</option>
                            <option value="ru">RU</option>
                          </select>
                        </div>
                      </div>
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col">
                          <h5 class="text-bold text-light">Your Primary Role (Complimentary)</h5>
                        </div>
                        <div class="col-3">
                          <select class="custom-select bg-light" name="primary_role" id="primary_role-2">
                            <option value="Top" selected="selected">Top</option>
                            <option value="Jungle">Jungle</option>
                            <option value="Mid">Mid</option>
                            <option value="ADC">ADC</option>
                            <option value="Support">Support</option>
                          </select>
                        </div>
                      </div>
                      <div class="row align-items-center mt-4 mb-4">
                        <div class="col">
                          <h5 class="text-bold text-light">Your Secondary Role (Complimentary)</h5>
                        </div>
                        <div class="col-3">
                          <select class="custom-select bg-light" name="secondary_role" id="secondary_role-2">
                            <option value="Top">Top</option>
                            <option value="Jungle" selected="selected">Jungle</option>
                            <option value="Mid">Mid</option>
                            <option value="ADC">ADC</option>
                            <option value="Support">Support</option>
                          </select>
                        </div>
                      </div>

                    </div>
                    </section>
                    <h3>Step 5 Title</h3>
                    <section>
                        <h2 class="section-heading mb-5 text-light">Enter Your Order Information</h2>

                        <div id="solo-info">
                          <div class="form-group">
                            <label class="text-light"  for="username" >Account Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                            <span class="invalid-feedback preUserSoloError" role="alert">
                                <strong class="text-danger" >Username is required.</strong>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="text-light"  for="password" >Account Password</label>
                            <input type="text" name="password" id="password" class="form-control" placeholder="Password" required>
                            <span class="invalid-feedback prePassSoloError" role="alert">
                                <strong class="text-danger" >Password is required.</strong>
                            </span>
                          </div>

                          <div class="form-group">
                            <label class="text-light"  for="summonerName" >Summoner Name <i class="fas fa-info-circle" alt="info-tool" data-toggle="tooltip" data-placement="top" title="Your Summoner Name is used to track your order in your Dashboard after ordering."></i></label>
                            <input type="text" name="summonerName" id="summonerName" class="form-control" placeholder="Summoner Name" required>
                            <span class="invalid-feedback preSummSoloError" role="alert">
                                <strong class="text-danger" >Summoner Name is required.</strong>
                            </span>
                          </div>

                          <div class="form-group">
                            <label class="text-light"  for="emailAddress" >Email Address</label>
                            <input type="email" name="emailAddress" id="emailAddress" class="form-control" placeholder="Email Address" required>
                            <span class="invalid-feedback preEmailSoloError" role="alert">
                                <strong class="text-danger" >Entered Email is invalid.</strong>
                            </span>
                          </div>

                          <div class="form-group">
                            <label class="text-light"  for="discord" >Discord ID (optional)</label>
                            <input type="text" name="discord" id="discord" class="form-control" placeholder="Temp#1234">
                          </div>

                          <div class="form-group">
                            <label class="text-light"  for="orderMessage">Order Message (optional)</label>
                            <input type="text" name="orderMessage" id="orderMessage" class="form-control" placeholder="Message">
                          </div>
                        </div>
                        <div id="duo-info">
                          <div class="form-group">
                            <label class="text-light"  for="summonerName">Summoner Name</label>
                            <input type="text" name="summonerName" id="summonerName2" class="form-control" placeholder="Summoner Name" >
                            <span class="invalid-feedback preSummDuoError" role="alert">
                                <strong class="text-danger" >Summoner Name is required.</strong>
                            </span>
                          </div>

                          <div class="form-group">
                            <label class="text-light"  for="emailAddress" >Email Address</label>
                            <input type="email" name="emailAddress" id="emailAddress2" class="form-control" placeholder="Email Address" >
                            <span class="invalid-feedback preEmailDuoError" role="alert">
                                <strong class="text-danger" >Entered Email is invalid.</strong>
                            </span>
                          </div>

                          <div class="form-group">
                            <label class="text-light"  for="discord" >Discord ID (optional)</label>
                            <input type="text" name="discord" id="discord2" class="form-control" placeholder="Temp#1234">
                          </div>
                          <div class="form-group">
                            <label class="text-light"  for="orderMessage">Order Message (optional)</label>
                            <input type="text" name="orderMessage" id="orderMessage2" class="form-control" placeholder="Message">
                          </div>
                        </div>




                    </section>
                    <h3>Step 6 Title</h3>
                    <section>
                        <h2 class="section-heading mb-5 text-light">Review your Order and Submit</h2>
                        <h3 class="text-muted">Order Summary</h3>
                        <table class="table table-bordered table-hover table-striped table-dark mb-5">
                        <thead>
                          <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Information</th>
                            <th scope="col">Price</th>
                          </tr>
                        </thead>
                        <tbody id="table-order-info">
                          <tr>
                            <td>Solo or Duo</td>
                            <td id="finalSoloDuo">Solo</td>
                          </tr>
                          <tr>
                            <td>Order Type</td>
                            <td id="finalOrderType">Solo Division</td>
                          </tr>
                          <tr>
                            <td>Order Details</td>
                            <td id="finalOrderInfo">Iron 4 to Bronze 4</td>
                          </tr>

                          <tr>
                            <td>Order Information</td>
                            <td id="primaryRoleText"></td>
                          </tr>

                        </tbody>
                      </table>

                      <div class="form-group mt-5 mb-5">

                        <div class="row container-sm">
                          <div class="col-7">
                            <label for="orderMessage" class="sr-only text-light">Discount Code</label>
                            <input type="text" name="discount_code" id="discount_code" class="form-control" placeholder="Discount Code">
                          </div>
                          <div class="col-3 align-self-center">
                            <button type="button" class="btn btn-primary container-fluid" id="applyDiscount">Apply</button>
                          </div>
                        </div>
                        <div class="row container-sm">
                          <div class="col-7">
                            <p id="discount_error"class=text-danger>Incorrect/Invalid Discount Code</p>
                          </div>

                        </div>
                        <div class="row container-sm mt-5 mb-5">
                        <form id="payment-form">
                          <div id="card-element" class="form-control"><!--Stripe.js injects the Card Element--></div>
                          <button id="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay</span>
                          </button>
                          <p id="card-error" role="alert"></p>
                          <p class="result-message hidden">
                            Payment succeeded, see the result in your
                          </p>
                        </form>

                      </div>

                      <form method="POST" id="newUserForm" name="endForm" action="{{ route('register') }}">

                      <!-- Modal -->
                      <div class="modal fade" id="orderUserRegisterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title text-primary text-bold" id="oURMLabel">Create Your BMS Account</h5>

                            </div>
                            <div class="modal-body ">
                              <p class="text-dark">Our records indicate you do not have an account with BMS!</p><br>
                              <p class="text-dark">Please make an account here in order to have access to your order management dashboard after ordering.</p>
                                  @csrf

                                  <div class="form-group row">
                                      <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>

                                      <div class="col-md-6">
                                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                          @error('name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                                      <div class="col-md-6">
                                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                              <span class="invalid-feedback endEmailError" role="alert">
                                                  <strong>Entered Email is invalid.</strong>
                                              </span>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('Password') }}</label>

                                      <div class="col-md-6">
                                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                          <span class="invalid-feedback endPassError1" role="alert">
                                              <strong>Entered Password too short (must be at least 8 characters).</strong>
                                          </span>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="password-confirm" class="col-md-4 col-form-label text-md-left">{{ __('Confirm Password') }}</label>

                                      <div class="col-md-6">
                                          <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                          <span class="invalid-feedback endPassError2" role="alert">
                                              <strong>Entered Passwords do not match.</strong>
                                          </span>
                                      </div>

                                  </div>

                                  <div class="form-group row">

                                  <input id="id" type="text" class="form-control invisible userFormClientID" value="123" name="id" readonly>
                                  </div>

                                  <div class="form-group row">

                                  <input id="ongoing_orders_arr" class="form-control invisible userFormOOA" value="[]" name="ongoing_orders_arr" readonly>
                                  </div>
                                  <div class="form-group row">

                                  <input id="current_orders_arr" class="form-control invisible userFormOOA" value="[]" name="current_orders_arr" readonly>
                                  </div>



                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-secondary invisible endFormSubmittor">Register</button>
                              <button type="button" class="btn btn-primary endFormValidator">{{ __('Register') }}</button>

                            </div>
                          </div>
                        </div>
                      </div>
                      </form>

                    </section>
                  </div>

                  </div>
                </div>
                <div class="col-2 align-self-center">
                  <div class="card float-left bg-light ml-4" id="price-preview" visible="false">
                    <h5 class="card-header bg-dark">Order Price</h5>
                    <div class="card-body bg-dark">
                      <h5 class="card-title text-center container-fluid" id="temp-order-price"></h5>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-1"></div>
              <div class="col mb-5">
                <section class="section wow fadeIn" data-wow-delay="0.3s">

                      <!--Section heading-->
                      <h1 class="font-weight-bold text-center h1 my-5 text-light">Why Choose <a class="text-primary">Us</a>?</h1>

                      <!--Section description-->
                      <p class="text-center text-muted text-light mb-5 mx-auto w-responsive lead">Our team has developed a custom application to streamline your ordering experience from placing your order, to the completion of your order.</p>

                      <!--Grid row-->
                      <div class="row">

                        <!--Grid column-->
                        <div class="col-md-4">

                          <!--Grid row-->
                          <div class="row mb-2">
                            <div class="col-2">
                              <i class="fas fa-2x fa-user-tie blue"></i>
                            </div>
                            <div class="col-10">
                              <h5 class="font-weight-bold mb-4 text-light">Management At Every Step</h5>
                              <p class="text-light">Unlike other services, we designed our ordering process so our veteran management team will be monitoring and verifying the status of your order at every stage..</p>
                            </div>
                          </div>
                          <!--Grid row-->

                          <!--Grid row-->
                          <div class="row mb-2">
                            <div class="col-2">
                              <i class="fas fa-2x fa-eye blue"></i>
                            </div>
                            <div class="col-10">
                              <h5 class="font-weight-bold mb-4 text-light">Track Your Order</h5>
                              <p class="text-light">You will be able to track your account's rank in your Order Dashboard after ordering.</p>
                            </div>
                          </div>
                          <!--Grid row-->

                          <!--Grid row-->
                          <div class="row mb-2">
                            <div class="col-2">
                              <i class="fas fa-2x fa-comment-alt blue"></i>
                            </div>
                            <div class="col-10">
                              <h5 class="font-weight-bold mb-4 text-light">Chat with your booster</h5>
                              <p class="text-light">After ordering, you will have a private channel to message your booster throughout the duration of the order.</p>
                            </div>
                          </div>
                          <!--Grid row-->

                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-4 mb-2 text-center flex-center">
                          <img src="https://app.bmsboosting.com/img/macbook-mockup-png-3.png" alt="" class="z-depth-0 mt-5">
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-4">

                          <!--Grid row-->
                          <div class="row mb-2">
                            <div class="col-2">
                              <i class="fas fa-2x fa-pause blue"></i>
                            </div>
                            <div class="col-10">
                              <h5 class="font-weight-bold mb-4 text-light">Pause Your Order</h5>
                              <p class="text-light">We offer clients the ability to pause/unpause their order for all order options.</p>
                            </div>
                          </div>
                          <!--Grid row-->

                          <!--Grid row-->
                          <div class="row mb-2">
                            <div class="col-2">
                              <i class="fas fa-2x fa-lock blue"></i>
                            </div>
                            <div class="col-10">
                              <h5 class="font-weight-bold mb-4 text-light">Secure Ordering Experience</h5>
                              <p class="text-light">Our ordering process was designed from scratch with a priority in User Experience and Security for a private ordering experience.</p>
                            </div>
                          </div>
                          <!--Grid row-->

                          <!--Grid row-->
                          <div class="row mb-2">
                            <div class="col-2">
                              <i class="fas fa-2x fa-robot blue"></i>
                            </div>
                            <div class="col-10">
                              <h5 class="font-weight-bold mb-4 text-light">Automated Process</h5>
                              <p class="text-light">We developed a special program that accelerates the process of getting an ELO Booster assigned to your order, and provides you with order updates to your email or dashboard.</p>
                            </div>
                          </div>
                          <!--Grid row-->

                        </div>
                        <!--Grid column-->

                      </div>
                      <!--Grid row-->

                    </section>
              </div>
              <div class="col-1"></div>
            </div>

          </div>
        </div>
        </main>

    </div>
    <!-- Footer -->
    <footer class="page-footer font-small footerBg pt-4 footerParr">

      <!-- Footer Links -->
      <div class="container-fluid text-center text-md-left">

        <!-- Grid row -->
        <div class="row">

          <!-- Grid column -->
          <div class="col-md-3 mt-md-0 mt-3">

            <!-- Content -->
            <img src="/img/profile/profile.png" width="197" height="180" alt="BMS Boosting Logo">


          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none pb-3">

          <!-- Grid column -->
          <div class="col-md-3 mb-md-0 mb-3">

            <!-- Links -->
            <h5 class="text-uppercase footerTitle">ELO BOOSTING AND COACHING</h5>

            <ul class="list-unstyled">
              <li>
                <a class="footerLink" href="https://www.bms-dash.herokuapp.com/boosting">Boosting</a>
              </li>

              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/coaching/">Coaching</a>
              </li>
            </ul>

          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 mb-md-0 mb-3">

            <!-- Links -->
            <h5 class="text-uppercase footerTitle">Account Selling</h5>

            <ul class="list-unstyled">
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/account-selling/">Accounts Store</a>
              </li>
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/cart/">Accounts Cart</a>
              </li>

            </ul>

            <!-- Links -->
            <h5 class="text-uppercase footerTitle">About Us</h5>

            <ul class="list-unstyled">
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/reviews/">Reviews</a>
              </li>
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/team">Our Team</a>
              </li>

              </li>
            </ul>

          </div>
          <!-- Grid column -->
          <!-- Grid column -->
          <div class="col-md-3 mb-md-0 mb-3">

            <!-- Links -->
            <h5 class="text-uppercase footerTitle">Help Centre</h5>

            <ul class="list-unstyled">
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/tos/">Terms of Service</a>
              </li>
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/faq/">F.A.Q.</a>
              </li>
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/contact-us">Contact Us</a>
              </li>
              <li>
                <a class="footerLink" href="https://www.bmsboosting.com/booster-applications/">Booster Applications</a>
              </li>
            </ul>



          </div>
          <!-- Grid column -->

        </div>
        <!-- Grid row -->

      </div>
      <!-- Footer Links -->

      <!-- Copyright -->
      <div class="footer-copyright text-center py-3 copyBg">© <a class="footerLink" href="https://bmsboosting.com">BMS Boosting</a>   |   All Rights Reserved   |    admin@bmsboosting.com   |   Website By <a class="footerLink" href="https://bmswebdesign.com">BMS Web Design</a>    |   League of Legends is a registered trademark of Riot Games, Inc. We are in no way affiliated with, associated with or endorsed by Riot Games, Inc.

      </div>
      <!-- Copyright -->

    </footer>
    <!-- Footer -->
    <script src="{{'js/app.js'}}"></script>
    <script src="{{'./resources/js/app.js'}}"></script>

    <script src="./assets/js/jquery.steps.min.js"></script>
    <script src="./assets/js/bd-wizard.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AUhiAnfqWuMkr2u63RKODnJQojrQ6YmwhOUaU7fEjFQRDfEH5SIXulUKxQnMUloUR7Tv6MzaYX83M8xA">
    </script>
    <script>
      var stripe = Stripe("pk_live_51ImUGXEalNLrduvqHtUVo2hcfvRFsEyc2cH2JEUjewoDT3yWHu6TndhGxzDvgNg07Q0wuEtzuiLmtSUjJ7RIBd3L009RxGs1FY");
      var elements = stripe.elements();
      var style = {
        base: {
          color: "#32325d",
          fontFamily: 'Arial, sans-serif',
          fontSmoothing: "antialiased",
          fontSize: "16px",
          "::placeholder": {
            color: "#32325d"
          }
        },
        invalid: {
          fontFamily: 'Arial, sans-serif',
          color: "#fa755a",
          iconColor: "#fa755a"
        }
      };
      var card = elements.create("card", { style: style });
      // Stripe injects an iframe into the DOM
      card.mount("#card-element");
      card.on("change", function (event) {
        // Disable the Pay button if there are no card details in the Element
        document.querySelector("button").disabled = event.empty;
        document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
      });
      var form = document.getElementById("payment-form");
      //console.log(data.json())
      form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        //console.log(cSec)
        // Complete payment when the submit button is clicked
        startStripe();
        //payWithCard(stripe, card, cSec.clientSecret);
      });


      var startStripe = function(){
        
        makeNewInvoiceID();
        let reqPrice = orderPrice;
        console.log(reqPrice)
        if(discountedPrice > 0){
          reqPrice = discountedPrice;
        }
        reqPrice = Math.round((reqPrice + Number.EPSILON) * 100) / 100;

        console.log(orderPrice)

        fetch("https://app.bmsboosting.com/api/create-stripe-transaction", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
              price: reqPrice,
              description: orderPPString,
              id: orderIdUnique,
            })
        }).then(async (data)=> {
          //console.log(data.json())
          let cSec = await data.clone().json()
          payWithCard(stripe, card, cSec.clientSecret);
          
          

        
        });
      }
    // Calls stripe.confirmCardPayment
    // If the card requires authentication Stripe shows a pop-up modal to
    // prompt the user to enter authentication details without leaving your page.
    var payWithCard = function(stripe, card, clientSecret) {
      loading(true);
      stripe
        .confirmCardPayment(clientSecret, {
          payment_method: {
            card: card
          }
        })
        .then(function(result) {
          if (result.error) {
            // Show error to your customer
            showError(result.error.message);
          } else {
            // The payment succeeded!
            orderComplete(result.paymentIntent.id);
          }
        });
    };
    /* ------- UI helpers ------- */
    // Shows a success message when the payment is complete
    var orderComplete = async function(paymentIntentId) {
      loading(false);
      document
        .querySelector(".result-message")
        .setAttribute(
          "href",
          "https://dashboard.stripe.com/test/payments/" + paymentIntentId
        );
      document.querySelector(".result-message").classList.remove("hidden");
      document.querySelector("button").disabled = true;
      //let caReturn ='';
      checkAccountEnd(paymentIntentId)
    };
    // Show the customer the error from Stripe if their card fails to charge
    var showError = function(errorMsgText) {
      loading(false);
      var errorMsg = document.querySelector("#card-error");
      errorMsg.textContent = errorMsgText;
      setTimeout(function() {
        errorMsg.textContent = "";
      }, 4000);
    };
    // Show a spinner on payment submission
    var loading = function(isLoading) {
      if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("button").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
      } else {
        document.querySelector("button").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
      }
    };


    </script>
    <script>
      /*let caReturn ='';
      paypal.Buttons({
        style:{
          color: 'blue',
        },

        createOrder: function() {
          caReturn = checkAccount();
          //console.log('careturn 1 is ' + caReturn);

          makeNewInvoiceID();
          let reqPrice = orderPrice;
          if(discountedPrice > 0){
            reqPrice = discountedPrice;
          }
          reqPrice = Math.round((reqPrice + Number.EPSILON) * 100) / 100;
        return fetch('https://app.bmsboosting.com/api/create-paypal-transaction', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            price: reqPrice,
            description: orderPPString,
            id: orderIdUnique,
          })
        }).then(function(res) {
          return res.json();
        }).then(function(data) {
          //console.log(data);
          return data.result.id; // Use the same key name for order ID on the client and server
        });
      },
      onApprove: function(data) {
        let clientID = makeClientID();
        let existStatus = false;
        let fixedPrice = orderPrice.toFixed(2);
        //caReturn = order.client_id;
        order.client_id = clientID;
        //console.log(caReturn);
        //console.log(order);
        //console.log('arr index cr' + clientID);
        if(caReturn.length!=0){
          //console.log('careturn not empty');
          existStatus = true;
          clientID = caReturn[0];
          order.client_id = caReturn[0];
        }else{
          //console.log('careturn is empty');
        }

        //console.log(data);
        setupOrdersArr();

        return fetch('https://app.bmsboosting.com/api/capture-stripe-transaction', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID,          //this may be diff, check stripe v
            id_invoice: orderIdUnique,
            orderType: orderPPString,
            orderOne:orderSoloDuoString,
            orderTwo:orderTypeString,
            orderThree:orderInfoString,
            clienter_id: [clientID],
            price: fixedPrice,
            client_email: email,
            message: JSON.stringify(orderFormObj),
            accountExists: existStatus,
            orderObj: JSON.stringify(order),

          })
        }).then(function(res) {
          //console.log(data);
          //console.log(res);
        }).then(function(details) {
          if(!accountExists){
            modalActivity();
          }else{
            window.location.replace('https://app.bmsboosting.com/login');
          }

        })
    }
  }).render('#paypalButtons');
  */
  </script>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/59ecd58a4854b82732ff7036/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
</body>
</html>