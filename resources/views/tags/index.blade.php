@extends('layouts.app')

@section('content')

    <div class="container">

        <h4 class="text-center">
            tags list
        </h4>
        <hr class="bg-dark">
        <a class="btn btn-primary btn-sm" href="{{ route('tags.create')}}" role="button">
            add new tag
        </a>
        <table class="table table-striped table-bordered mt-2">
            <thead>
                <tr>
                    <th scope="col">name</th>
                    <th scope="col">actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $id => $tag)
                    <tr>
                        <td>{{ $tag }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  actions
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a class="dropdown-item text-center" href="{{ route('tags.edit', $id)}}">Edit tag</a>
                                  <form action="{{ route('tags.destroy', $id)}}" method="POST" class="dropdown-item">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input class="btn" type="submit" value="Delete tag" />
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
