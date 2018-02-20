<div class="row">
    <div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="pass_anterior" class="control-label">Contraseña Actual:</label>
            {{ form::password('pass_anterior', ["class" => 'form-control',
                    "required" => 'true', "value" => " old('pass_anterior') ", 'placeholder' => 'Introduzca su contraseña actual']) }}
            @if ($errors->has('pass_anterior'))
                <span class="help-block">
                <strong>{{ $errors->first('pass_anterior') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="password" class="control-label">Nueva contraseña:</label>
            {{ form::password('password', ["class" => 'form-control',
                    "required" => 'true', "value" => " old('password') ", 'placeholder' => 'Introduzca la nueva contraseña']) }}
            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="password_repetir" class="control-label">Repita la contraseña:</label>
            {{ form::password('password_repetir', ["class" => 'form-control',
                    "required" => 'true', "value" => " old('password_repetir') ", 'placeholder' => 'Repita la nueva contraseña']) }}
            @if ($errors->has('password_repetir'))
                <span class="help-block">
                <strong>{{ $errors->first('password_repetir') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>