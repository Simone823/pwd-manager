<footer class="position-fixed bottom-0 w-100 py-2 bg-dark text-violet shadow-top z-50">
    <div class="container">
        <div class="row">

            <div class="col-12 d-flex align-items-center justify-content-between">
                {{-- copryright --}}
                <h6 class="mb-0 d-flex flex-wrap gap-2">
                    &copy;Copyright {{date('Y')}}
                    <a class="link-violet text-decoration-none fs-6" target="_blank" href="https://simonedaglio.it" alt="Simone Daglio">@Simone Daglio</a>
                </h6>

                {{-- version app --}}
                <h6 class="mb-0">v {{config('app.version')}}</h6>
            </div>

        </div>
    </div>
</footer>