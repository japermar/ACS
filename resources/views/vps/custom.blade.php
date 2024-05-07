@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wc-bubble"></script>
    <style>

    </style>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <form action="{{ route('upload_bash_file', [$vps_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="bash_file">Select Bash File:</label>
            <input type="file" name="bash_file" id="bash_file" class="form-control-file" accept=".sh">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
@endsection
