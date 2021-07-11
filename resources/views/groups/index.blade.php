@extends('layouts.app')

@section('content')

    <div class="container">

        <h4 class="text-center">
            Groups list
        </h4>
        <hr class="bg-dark">
        <a class="btn btn-primary btn-sm" href="{{ route('groups.create')}}" role="button">
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
                @foreach ($groups as $id => $group)
                    <tr>
                        <td>{{ $group }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  actions
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a class="dropdown-item text-center" href="{{ route('groups.show', $id)}}">show group details</a>
                                  <a class="dropdown-item text-center" href="{{ route('groups.edit', $id)}}">Edit group</a>
                                  <form action="{{ route('groups.destroy', $id)}}" method="POST" class="dropdown-item">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input class="btn" type="submit" value="Delete group" />
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
