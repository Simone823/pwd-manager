{{-- Button --}}
<button type="button" class="link-light-gray border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
    Cambia Password
</button>

<!-- Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changePasswordModalLabel">
                    Cambia Password
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- flash message--}}
                @include('components.flashMessage')

                <form action="{{route('profiles.changePassword', $user->id)}}" method="post">
                    @csrf

                    {{-- password --}}
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password" name="password" value="" placeholder="Password" required autocomplete="new-password">
                        <label for="password" class="text-violet">Password*</label>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- password confirm --}}
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password-confirm" name="password_confirmation" value="" placeholder="Conferma Password" required>
                        <label for="password-confirm" class="text-violet">Conferma Password*</label>

                        @error('password_confirm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- buttons --}}
                <div class="modal-footer d-flex gap-2">
                    <button type="submit" class="btn btn-violet fw-bold px-4 text-uppercase">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Salva
                    </button>
                    <button type="button" class="btn btn-violet fw-bold px-4 text-uppercase" data-bs-dismiss="modal">
                        <i class="fa-solid fa-ban"></i>
                        Annulla
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>