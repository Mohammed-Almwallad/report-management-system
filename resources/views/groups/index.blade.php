@extends('layouts.app')

@section('content')

    <div class="container">

        <h4 class="text-center">
            Groups list
        </h4>
        <hr class="bg-dark">
        <a class="btn btn-primary btn-sm" href="{{ route('users.create')}}" role="button">
            add new group
        </a>
        <table class="table table-striped table-bordered mt-2">
            <thead>
                <tr>
                    <th scope="col">name</th>
                    <th scope="col">actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  actions
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a class="dropdown-item text-center" href="{{ route('users.show', $user->id)}}">show user details</a>
                                  <a class="dropdown-item text-center" href="{{ route('users.edit', $user->id)}}">Edit user</a>
                                  <form action="{{ route('users.destroy', $user->id)}}" method="POST" class="dropdown-item">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input class="btn" type="submit" value="Delete user" />
                                 </form>
                                </div>
                              </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </div>
    </table>
@endsection
