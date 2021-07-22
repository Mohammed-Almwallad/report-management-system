@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('report data') }}</div>
                    <div class="card-body">
                        <div class="container border border-dark">
                            <div class="row mt-3">
                                <div class="col-2">
                                    <h4>
                                        name :
                                    </h4>
                                </div>
                                <div class="col-10 mt-1 text-left">
                                    <h5 class="text-left">
                                        {{ $report->name}}
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <h4>
                                        content:
                                    </h4>
                                </div>
                                <div class="col-10">
                                    <h5>
                                        {{ $report->content}}
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <h4>
                                        group :
                                    </h4>
                                </div>
                                <div class="col-10 mt-1">
                                    <h5>
                                        {{ $report->group->name}}
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <h4>
                                        tags :
                                    </h4>
                                </div>
                                <div class="col-10 mt-1">
                                    <h5>
                                        @foreach ($report->tags as $tag)

                                            {{ $tag->name}}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <h4>
                                        files :
                                    </h4>
                                </div>
                                <div class="col-10">

                                    @foreach ($report->report_files as $files)
                                        
                                    <a href="/storage/files/{{ $files->file_url}}" class="btn btn-primary">File {{ $loop->iteration }}</a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-4">
                                    <h4>
                                        uploader name :
                                    </h4>
                                </div>
                                <div class="col-8 mt-1">
                                    <h5>
                                        {{ $report->user->name}}
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
