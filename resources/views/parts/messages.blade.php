@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Operación Exitosa:</strong> {{ Session::get('success') }}
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible" role="alert" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Errores:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif