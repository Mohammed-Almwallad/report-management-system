@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('edit report') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reports.update', $report->id)}}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $report->name }}" required autocomplete="name" autofocus>

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
                                <textarea id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" value="{{ $report->content }}" required autocomplete="content">{{ $report->content }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="groups" class="col-md-4 col-form-label text-md-right">{{ __('choose a group') }}</label>

                            <div class="col-md-6">
                                <select  class="form-control" id="groups" name="group_id" required autocomplete="group">
                                    @foreach ($groups as $id => $group)
                                    @if ($report->group->name == $group)
                                    <option value="{{ $id }}" selected>{{ $group }}</option>
                                    @else
                                    <option value="{{ $id }}">{{ $group }}</option>
                                    @endif
                                    @endforeach
                                  </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="groups" class="col-md-4 col-form-label text-md-right">{{ __('choose tags') }}</label>

                            <div class="col-md-6">
                                <select multiple class="form-control" id="groups" name="tags[]" required autocomplete="tags">
                                    @foreach ($tags as $id => $tag)
                                    @if (in_array($tag, $report['tags']))
                                    <option value="{{ $id }}" selected>{{ $tag }}</option>                                        
                                    @else
                                    <option value="{{ $id }}">{{ $tag }}</option>
                                    @endif
                                    @endforeach
                                  </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deletefiles" class="col-md-4 col-form-label text-md-right">{{ __('delete old files') }}</label>

                            <div class="col-md-6">
                                <select  class="form-control" id="deletefiles" name="delete_old_files" required autocomplete="group">
                                    <option value="true" selected>yes</option>
                                    <option value="false">no</option>
                                  </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="files" class="col-md-4 col-form-label text-md-right">{{ __('choose files') }}</label>

                            <div class="col-md-6">
                                <input id="files" multiple  type="file" class="form-control-file @error('file') is-invalid @enderror" name="files[]" value="{{ old('files') }}"  autocomplete="files">
                                
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
                                    {{ __('edit') }}
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