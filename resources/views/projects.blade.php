@extends('layouts.user_type.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-2 col-sm-6">
            <a class="nav-link p-0 {{ (Request::is('projects') ? 'active' : '') }} " href="{{ url('projects') }}">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            <i class="fas fa-landmark opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0"></h6>
                        <span class="text-xs">Mathematics</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">Project 1</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0"></h6>
                    <span class="text-xs">Mathematics</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">Project 1</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0"></h6>
                    <span class="text-xs">Mathematics</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">Project 1</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0"></h6>
                    <span class="text-xs">Mathematics</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">Project 1</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0"></h6>
                    <span class="text-xs">Mathematics</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">Project 1</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0"></h6>
                    <span class="text-xs">Mathematics</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">Project 1</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
