@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('Group data') }}</div>
                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" readonly class="form-control-plaintext" @error('name') is-invalid @enderror"
                                        name="name" value="{{ $group->name }}" required autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="groups"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Users assgined to this group') }}</label>

                                <div class="col-md-6 mt-2">
                                        @foreach ($group->users as $id => $user)
                                            <p>{{ $user }}</p>
                                        @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
