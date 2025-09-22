<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-success mb-0">@yield('title')</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        {{--  <div class="alert alert-danger" role="alert">
            Your SMS balance is {{ $settings->credits }}, please contact support on <b>+233 54 880 1288</b> to top up.
        </div>  --}}
    </div>
</div>
