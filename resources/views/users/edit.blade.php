@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('update user data') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            {{ method_field('PUT') }}
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $user->name }}" required autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ $user->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="roles"
                                    class="col-md-4 col-form-label text-md-right">{{ __('User roles') }}</label>

                                <div class="col-md-6">
                                    <select multiple class="form-control" id="roles" name="roles[]" required
                                        autocomplete="roles">
                                        @foreach ($roles as $id => $role)
                                            @if ($user->hasRole($role))
                                            <option value="{{ $id }}" selected>{{ $role }}</option>
                                            @else
                                            <option value="{{ $id }}">{{ $role }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="groups"
                                    class="col-md-4 col-form-label text-md-right">{{ __('User groups') }}</label>

                                <div class="col-md-6">
                                    <select multiple class="form-control" id="groups" name="groups[]" required
                                        autocomplete="groups">
                                        @foreach ($groups as $id => $group)
                                            @if (in_array($group, $user->groups))
                                            <option value="{{ $id }}" selected>{{ $group }}</option>
                                            @else
                                            <option value="{{ $id }}">{{ $group }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit') }}
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
