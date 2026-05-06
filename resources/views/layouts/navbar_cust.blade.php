<nav class="navbar navbar-default header-section">
    <div class="container">

        <!-- BRAND -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="{{ route('customer.index_cust') }}">
                <img src="{{ asset('cust/image/logotarot.png') }}" width="55" height="35">
            </a>
        </div>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="nav-collapse">

            <!-- LEFT MENU -->
            <ul class="nav navbar-nav">
                <li><a href="{{ route('customer.index_cust') }}">Home</a></li>
                <li><a href="{{ route('customer.service_cust') }}">Service</a></li>
                <li><a href="{{ route('customer.testimonial_cust') }}">Testimonials</a></li>
                <li><a href="{{ route('customer.about_cust') }}">About</a></li>
                <li><a href="{{ route('customer.contact_cust') }}">Contact</a></li>
            </ul>

            <!-- RIGHT MENU -->
            <ul class="nav navbar-nav navbar-right">

                <!-- CART -->
                <li>
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i> Cart
                    </a>
                </li>

                <!-- 🔥 AUTH -->
                @guest
                    <li>
                        <a href="/login" class="btn btn-pink" style="margin-top:8px; padding:5px">
                            Login
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#modalHistory">
                                    History
                                </a>
                            </li>
                            <li>
                                <form action="/logout" method="POST" style="margin:0;">
                                    @csrf
                                    <button style="border:none; background:none; padding:10px 20px; width:100%; text-align:left;">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>