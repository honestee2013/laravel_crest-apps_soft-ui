
<div class="form-group">
        <label for="team_id" class="form-control-label">Team</label>

        <select class="form-select{{ $errors->has('team_id') ? ' is-invalid' : '' }}" id="team_id" name="team_id">
        	    <option value="" style="display: none;" {{ old('team_id', optional($role)->team_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select team</option>
        	@foreach ($teams as $key => $team)
			    <option value="{{ $key }}" {{ old('team_id', optional($role)->team_id) == $key ? 'selected' : '' }}>
			    	{{ $team }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('team_id', '<div class="invalid-feedback">:message</div>') !!}
</div>

<div class="form-group">
        <label for="name" class="form-control-label">Name</label>

        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($role)->name) }}" minlength="1" maxlength="255" required="true" placeholder="Enter name here...">

        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
</div>

<div class="form-group">
        <label for="description" class="form-control-label">Description</label>

        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" type="text" id="description" value="{{ old('description', optional($role)->description) }}" minlength="1" maxlength="255" required="true">

        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
</div>

