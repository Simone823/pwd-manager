@if ($message = Session::get('success'))
    <div class="container mt-4 alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  
@if ($message = Session::get('error'))
    <div class="container mt-4 alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
   
@if ($message = Session::get('warning'))
    <div class="container mt-4 alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
   
@if ($message = Session::get('info'))
    <div class="container mt-4 alert alert-info alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  
@if ($errors->any())
    <div class="container mt-4 alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Controllare che il modulo sottostante non contenga errori!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif