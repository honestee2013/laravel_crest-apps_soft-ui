
<div class="form-group">
        <label for="name" class="form-control-label">Name</label>

        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($permission)->name) }}" minlength="1" maxlength="255" required="true" placeholder="Enter name here...">

        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
</div>

<div class="form-group">
        <label for="description" class="form-control-label">Description</label>

        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" type="text" id="description" value="{{ old('description', optional($permission)->description) }}" minlength="1" maxlength="255" required="true">

        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
</div>

