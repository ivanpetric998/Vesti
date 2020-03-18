<div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">
            <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>

    </div>


    <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-header">MENI</li>

            @foreach($meni as $i)
                <li class="nav-item">
                    <a href="{{ url($i->link) }}" class="nav-link">
                        <p>
                            {{ $i->tekst }}
                        </p>
                    </a>
                </li>
            @endforeach



        </ul>

    </nav>

</div>