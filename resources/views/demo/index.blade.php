@extends('layouts.app')

@section('title', '| Demo')

@section('content')
    <section id="demo-index" class="h-100">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-12">
    
                    {{-- logo --}}
                    <a href="{{url('/')}}" alt="{{config('app.name')}}">
                        <figure class="logo-large mx-auto mb-5">
                            <img src="{{asset('assets/img/icon-site/icon-large-svg.svg')}}" alt="{{config('app.name') . ' logo'}}">
                        </figure>
                    </a>
    
                    {{-- form prepare demo --}}
                    <div class="form-prepare-demo pt-4 mb-5">
                        <form class="d-flex justify-content-center" method="POST" action="{{ route('demo.prepareDemo') }}">
                            @csrf

                            {{-- submit --}}
                            <button type="submit" class="btn btn-violet fs-16px px-4 shadow">
                                Prepara Demo
                            </button>
                        </form>
                    </div>

                    {{-- info demo --}}
                    <div class="info-demo text-white text-center">
                        <p class="mb-0 fs-16px">Tempo normale di preparazione della Demo: 15-30 secondi</p>
                        <p class="mb-0 fs-16px">Durata della Demo (si ripristina): 30 minuti</p>
                    </div>
    
                </div>
            </div>
        </div>
    </section>
@endsection