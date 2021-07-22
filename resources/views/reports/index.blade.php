@extends('layouts.app')
@php
    $user = auth()->user();
@endphp
@section('content')

    <div class="container">

        <h4 class="text-center">
            reports list
        </h4>
        <hr class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-6 p-0">
                    @if ($user->hasRole('create-reports') || $user->isAdmin())
                    <a class="btn btn-primary btn-sm" href="{{ route('reports.create')}}" role="button">
                        add new report
                    </a>
                    @endif
                </div>
                <div class="col-6 p-0">
                    <form method="POST" action="{{ route('reports.search')}}">
                        @csrf
                        <div class="row">
                          <div class="col">
                            <input type="text" name="text" class="form-control" placeholder="search">
                          </div>
                          <div class="col">
                            <div class="form-group">
                                <select class="form-control @error('search_by') is-invalid @enderror" name="search_by" id="search_by" required>
                                  <option value="name">report name</option>
                                  <option value="content">content</option>
                                  <option value="tag">tag</option>
                                  <option value="group">group</option>
                                  <option value="uploader">uploader</option>
                                  <option value="editor">editor</option>
                                </select>
                            </div>
                          </div>
                          <div class="col">
                              <button type="submit" class="btn btn-primary">Search</button>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered mt-2">
            <thead>
                <tr>
                    <th scope="col">name</th>
                    <th scope="col">group</th>
                    <th scope="col">actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->name }}</td>
                        <td>{{ $report->group->name }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  actions
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  @if ($user->hasRole('view-reports') || $user->isAdmin())
                                  <a class="dropdown-item text-center" href="{{ route('reports.show', $report->id)}}">show report details</a>
                                  @endif  

                                  @if ($user->hasRole('edit-reports') || $user->isAdmin())
                                  <a class="dropdown-item text-center" href="{{ route('reports.edit', $report->id)}}">Edit report</a>
                                  @endif

                                  @if ($user->hasRole('delete-reports') || $user->isAdmin())      
                                  <form action="{{ route('reports.destroy', $report->id)}}" method="POST" class="dropdown-item">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input class="btn" type="submit" value="Delete report" />
                                  </form>
                                  @endif

                                </div>
                              </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </div>
    </table>
@endsection
