<header class="header_in clearfix">
    <div class="container">
        <div id="logo">
            <a href="index.html">
                {{--                <img src="{{asset('source/img/logo_info.png')}}" width="140" height="35" alt="" class="logo_normal">--}}
                <img src="{{ asset(getSetting('logo')) }}" width="140" height="35" alt="" class="logo_sticky">
            </a>
        </div>
        <ul id="top_menu">
            <div class="collapse dont-collapse-sm" id="collapse_4">
                <div id="newsletter">
                    <form method="get" action="{{ url('/cari') }}" name="form_menu" id="form_menu">
                        <div class="form-group">
                            <input type="text" name="query" id="cari" class="form-control"
                                   placeholder="Cari sesuatu.. ?">
                            <button type="submit" id="submit-newsletter"><i class="icon_search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </ul>
        <!-- /top_menu -->
        <a href="#0" class="open_close">
            <i class="icon_menu"></i><span>Menu</span>
        </a>
        <nav class="main-menu">
            <div id="header_menu">
                <a href="#0" class="open_close">
                    <i class="icon_close"></i><span>Menu</span>
                </a>
                <a href="#"><img src="{{asset('source/img/logo_info.png')}}" width="140" height="35" alt=""></a>
            </div>
            @php
                $segment_link = Request::segment(1);
            @endphp
            @if($segment_link!="")
                <ul>
                        <li class="">
                            <a href="{{url('/')}}" class="">Home</a>
                        </li>
                        @foreach(getKategori() as $d)
                            <li>
                                <a href="{{ url('/kategori') }}/{{ $d->seotitle }}">{{ ucfirst($d->title) }}</a>
                            </li>
                        @endforeach
                        <li class="">
                            <a href="{{url('/kontak')}}" class="">Kontak</a>
                        </li>
                </ul>
            @else
                <div id="newsletter" class="show-submenu-category" style="padding: 5px;margin-top: 5px;border-bottom: 1px solid #ededed;margin-bottom: 0px;">
                    <form method="get" action="{{ url('/cari') }}" name="form_menu_respon" id="form_menu_respon">
                        <div class="form-group">
                            <input type="text" name="query" id="cari_respon" class="form-control"
                                   placeholder="Cari sesuatu.. ?">
                            <button type="submit" id="submit-newsletter_respon"><i class="icon_search"></i></button>
                        </div>
                    </form>
                </div>
                <ul>
                    <li class="">
                        <a href="{{url('/')}}" class="">Home</a>
                    </li>
                    <li class="">
                        <a href="{{url('/kontak')}}" class="">Kontak</a>
                    </li>
                </ul>
                <ul class="show-submenu-category">
                    @foreach(getKategori() as $d)
                        <li class="submenu-category col-md-3">
                            <a style="padding: 0px !important;" href="{{ url('/kategori') }}/{{ $d->seotitle }}" class="submenu-category">
                                <img  height="20" width="20" src="{{asset($d->picture)}}">
                                &nbsp; {{ ucfirst($d->title) }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            @endif


        </nav>
    </div>
</header>