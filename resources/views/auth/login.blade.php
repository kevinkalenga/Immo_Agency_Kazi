     
@extends('frontend.frontend_dashboard')       
        
@section('main')   
     
     <!--Page Title-->
        <section class="page-title-two bg-color-1 centred">
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url({{asset('frontend/assets/images/shape/shape-9.png')}});"></div>
                <div class="pattern-2" style="background-image: url({{asset('frontend/assets/images/shape/shape-10.png')}});"></div>
            </div>
            <div class="auto-container">
                <div class="content-box clearfix">
                    <h1>Sign In</h1>
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li>Sign In</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--End Page Title-->


        <!-- ragister-section -->
        <section class="ragister-section centred sec-pad">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-xl-8 col-lg-12 col-md-12 offset-xl-2 big-column">
                        <div class="sec-title">
                           
                        </div>
                        <div class="tabs-box">
                            <div class="tab-btn-box">
                                <ul class="tab-btns tab-buttons centred clearfix">
                                    <li class="tab-btn active-btn" data-tab="#tab-1">Login</li>
                                    <li class="tab-btn" data-tab="#tab-2">Register</li>
                                </ul>
                            </div>
                            <div class="tabs-content">
                                <div class="tab active-tab" id="tab-1">
                                    <div class="inner-box">
                                        <h4>Sign in</h4>
                                        <form action="{{route('login')}}" method="post" class="default-form" novalidate>
                                            
                                        @if (session('status'))
                                           <div class="alert alert-success">
                                               {{ session('status') }}
                                           </div>
                                       @endif

                                       @if ($errors->any())
                                           <div class="alert alert-danger">
                                               <ul class="mb-0">
                                                   @foreach ($errors->all() as $error)
                                                       <li>{{ $error }}</li>
                                                   @endforeach
                                               </ul>
                                           </div>
                                       @endif
                                        
                                        
                                           
                                        
                                            @csrf
                                            <div class="form-group">
                                                <label>Name/Email/Phone</label>
                                                <input type="text" name="login" id="login" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" id="password" required="">
                                            </div>
                                            <div class="form-group message-btn">
                                                <button type="submit" class="theme-btn btn-one">Sign in</button>
                                            </div>
                                        </form>
                                        <div class="othre-text">
                                            <p>
                                                Have not any account?
                                                <a href="{{route('register')}}" class="go-register">Register Now</a>
                                            </p>

                                            <!-- <p>Have not any account? <a href="{{route('register')}}">Register Now</a></p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="tab" id="tab-2">
                                    <div class="inner-box">
                                        <h4>Sign Up</h4>
                                        <form action="{{route('register')}}" method="post" class="default-form" novalidate>
                                            @csrf
                                            
                                            
                                        @if (session('status'))
                                           <div class="alert alert-success">
                                               {{ session('status') }}
                                           </div>
                                       @endif

                                       @if ($errors->any())
                                           <div class="alert alert-danger">
                                               <ul class="mb-0">
                                                   @foreach ($errors->all() as $error)
                                                       <li>{{ $error }}</li>
                                                   @endforeach
                                               </ul>
                                           </div>
                                       @endif
                                            
                                            
                                            <div class="form-group">
                                                <label>User name</label>
                                                <input type="text" name="name" id="name" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Email address</label>
                                                <input type="email" name="email" id="email" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" id="password" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" required="">
                                            </div>
                                            <div class="form-group message-btn">
                                                <button type="submit" class="theme-btn btn-one">Register</button>
                                            </div>
                                        </form>
                                        <div class="othre-text">
                                            <p>
                                                Have you already an account?
                                                <a href="{{route('login')}}" class="go-login">Sign In</a>
                                            </p>

                                            <!-- <p>Have you already an account? <a href="{{route('login')}}">Sign In</a></p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ragister-section end -->


        <!-- subscribe-section -->
        <section class="subscribe-section bg-color-3">
            <div class="pattern-layer" style="background-image: url({{asset('frontend/assets/images/shape/shape-2.png')}});"></div>
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-column">
                        <div class="text">
                            <span>Subscribe</span>
                            <h2>Sign Up To Our Newsletter To Get The Latest News And Offers.</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-column">
                        <div class="form-inner">
                            <form action="contact.html" method="post" class="subscribe-form" novalidate>
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Enter your email" required="">
                                    <button type="submit">Subscribe Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- subscribe-section end -->
@endsection

<!-- Add script to redirect to Sign Up and Sign In -->
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    function activateTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active-btn');
        });
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active-tab');
        });

        document.querySelector('.tab-btn[data-tab="' + tabId + '"]')
            .classList.add('active-btn');

        document.querySelector(tabId).classList.add('active-tab');
    }

    document.querySelectorAll('.go-register').forEach(el => {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            activateTab('#tab-2');
        });
    });

    document.querySelectorAll('.go-login').forEach(el => {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            activateTab('#tab-1');
        });
    });

});
</script>
@endsection
