<nav class="navbar navbar-default header-section">
    <div class="container">

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

        <div class="collapse navbar-collapse" id="nav-collapse">

            <ul class="nav navbar-nav">
                <li><a href="{{ route('customer.index_cust') }}">Home</a></li>
                <li><a href="{{ route('customer.service_cust') }}">Service</a></li>
                <li><a href="{{ route('customer.testimonial_cust') }}">Testimonials</a></li>
                <li><a href="{{ route('customer.about_cust') }}">About</a></li>
                <li><a href="{{ route('customer.contact_cust') }}">Contact</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">


                @guest
                    <li>
                        <a href="/login" class="btn-pink" style="margin-top:10px; padding:5px 15px; display:inline-block;">
                            Login
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right" style="background-color: #111; border: 1px solid #3d3020;">
                            <li>
                                <a href="{{ url('/history') }}" style="color: #d4af37 !important; padding: 10px 20px;">
                                    <i class="fa fa-history"></i> Riwayat Booking
                                </a>
                            </li>
                            <li role="separator" class="divider" style="background-color: #3d3020; margin: 5px 0;"></li>
                            <li>
                                <form action="/logout" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" style="border:none; background:none; padding:10px 20px; width:100%; text-align:left; color: #ff4d4d;">
                                        <i class="fa fa-sign-out"></i> Logout
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