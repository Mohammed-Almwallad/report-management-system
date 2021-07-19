@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Add new report') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reports.store')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('content') }}</label>

                            <div class="col-md-6">
                                <textarea id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" value="{{ old('content') }}" required autocomplete="content"></textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('choose a group') }}</label>

                            <div class="col-md-6">
                                <select  class="form-control" id="roles" name="group_id" required autocomplete="group">
                                    @foreach ($groups as $id => $group)
                                    <option value="{{ $id }}">{{ $group }}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="groups" class="col-md-4 col-form-label text-md-right">{{ __('choose tags') }}</label>

                            <div class="col-md-6">
                                <select multiple class="form-control" id="groups" name="tags[]" required autocomplete="tags">
                                    @foreach ($tags as $id => $tag)
                                    <option value="{{ $id }}">{{ $tag }}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="files" class="col-md-4 col-form-label text-md-right">{{ __('choose files') }}</label>

                            <div class="col-md-6">
                                <input id="files" multiple  type="file" class="form-control-file @error('file') is-invalid @enderror" name="files[]" value="{{ old('files') }}" required autocomplete="files" autofocus>
                                
                                @error('files')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection