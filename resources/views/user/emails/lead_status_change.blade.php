@extends('emails.layouts.app')

@section('content')
    
    <title>{{ $subjectLine }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $subjectLine }}</h4>
            </div>
            <div class="card-body">
                <p class="lead">{{ $subjectLine ?? 'No message provided.' }}</p>
            <a href="{{ route('lead.view', ['id' => $details['id']]) }}"><h4>View Lead</h4></a>
            </div>

        </div>
    </div>


@endsection
