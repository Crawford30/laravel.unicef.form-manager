<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading d-flex justify-content-center">
        <a href="{{url("/")}}" class="d-contents">
            <img src="{{asset("images/unicef.logo.white.png")}}" height="80%">
        </a>
    </div>
    <div class="list-group list-group-flush mt-2">

        <a  href="{{url('home')}}" class="list-group-item list-group-item-action {{ request()->is('home') || request()->is('/') ? 'active' : ' ' }}">
            <div class="row">
                <div class="col-sm-1">
                    <i class="fas fa-home"></i>
                </div>
                <div class="col-sm-8">
                    <span>Home</span>
                </div>
            </div>
        </a>

        <a href="{{url('list-forms')}}" class="list-group-item list-group-item-action {{ request()->is('list-forms') ? 'active' : ' ' }}">
            <div class="row">
                <div class="col-sm-1">
                    <i class="far fa-file-alt"></i>
                </div>
                <div class="col-sm-8">
                    <span>Forms</span>
                </div>
            </div>
        </a>

         <a href="{{ route('data-forms') }}" class="list-group-item list-group-item-action {{ str_contains( URL::current(), 'data') ? 'active' : ' ' }}">
            <div class="row">
                <div class="col-sm-1">
                    <i class="fas fa-database"></i>
                </div>
                <div class="col-sm-8">
                    <span>Data</span>
                </div>
            </div>
        </a>
        @if(in_array('forms', auth()->user()->permissions))
        <a href="{{url('users-forms')}}" class="list-group-item list-group-item-action {{ request()->is('users-forms') ? 'active' : ' ' }}">
            <div class="row">
                <div class="col-sm-1">
                    <i class="fas fa-users"></i>
                </div>
                <div class="col-sm-8">
                    <span>Users</span>
                </div>
            </div>
        </a>

        <a href="{{ route('viewers-forms') }}" class="list-group-item list-group-item-action {{ request()->is('viewers-forms') ? 'active' : ' ' }}">
            <div class="row">
                <div class="col-sm-1">
                    <i class="fas fa-users"></i>
                </div>
                <div class="col-sm-8">
                    <span>Viewers</span>
                </div>
            </div>
        </a>

        <a href="#" data-toggle="modal" data-target="#modal-export-data-global" class="list-group-item list-group-item-action">
            <div class="row">
                <div class="col-sm-1">
                    <i class="fas fa-cloud-download-alt"></i>
                </div>
                <div class="col-sm-8">
                    <span>Export Data</span>
                </div>
            </div>
        </a>
        @endif

        
        <a href="{{route("help-center")}}" class="list-group-item list-group-item-action {{isLinkActive(["help-center"])}}">
            <div class="row">
                <div class="col-sm-1">
                    <i class="far fa-life-ring"></i>
                </div>
                <div class="col-sm-9">
                    <span>Help Center</span>
                </div>
            </div>
        </a>


        <a href="#" class="list-group-item list-group-item-action">
            <div class="row">
                <div class="col-sm-1">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="col-sm-8">
                    <span>Settings</span>
                </div>
            </div>
        </a>

    </div>
</div>
