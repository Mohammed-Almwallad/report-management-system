
<hr>
<div class="container">
    <h3 class="text-center">
        report {{ ++$index}}
    </h3>
</div>


<div class="form-group row"><label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label><div class="col-md-6"><input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="reports[{{ $index }}][name]"value="{{ old('name') }}" required autocomplete="name" autofocus></div></div>

<div class="form-group row">
    <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('content') }}</label>

    <div class="col-md-6">
        <textarea id="content" type="text" class="form-control @error('content') is-invalid @enderror"
            name="reports[{{ $index }}][content]" value="{{ old('content') }}" required autocomplete="content"></textarea>
    </div>
</div>

<div class="form-group row">
    <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('choose a group') }}</label>

    <div class="col-md-6">
        <select  class="form-control" id="roles" name="reports[{{ $index }}][group_id]" required autocomplete="group">
            @foreach ($groups as $id => $group)
            <option value="{{ $id }}">{{ $group }}</option>
            @endforeach
          </select>
    </div>
</div>

<div class="form-group row">
    <label for="groups" class="col-md-4 col-form-label text-md-right">{{ __('choose tags') }}</label>

    <div class="col-md-6">
        <select multiple class="form-control" id="groups" name="reports[{{ $index }}][tags][]" required autocomplete="tags">
            @foreach ($tags as $id => $tag)
            <option value="{{ $id }}">{{ $tag }}</option>
            @endforeach
          </select>
    </div>
</div>


<div class="form-group row">
    <label for="files" class="col-md-4 col-form-label text-md-right">{{ __('choose files') }}</label>

    <div class="col-md-6">
        <input id="files" multiple type="file" class="form-control-file @error('file') is-invalid @enderror"
            name="reports[{{ $index }}][files][]" value="{{ old('files') }}" required autocomplete="files" autofocus>
    </div>
</div>

