@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wc-bubble"></script>
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control-file {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control-file:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.15s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        #response {
            margin-top: 20px;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="form-container">
        <form hx-post="{{ route('upload_bash_file', [$vps_id]) }}" hx-target="#response" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="bash_file">Archivo Bash:</label>
                <input type="file" name="bash_file" id="bash_file" class="form-control-file" accept=".sh">
            </div>
            <button type="submit" class="btn btn-primary">Ejecutar</button>
        </form>
    </div>
    <style>
        #response {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        #response p {
            margin: 0 0 10px;
        }

        #response ul {
            margin: 0;
            padding-left: 20px;
        }

        #response pre {
            margin: 0;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Consolas, monospace;
            font-size: 14px;
            line-height: 1.4;
            overflow-x: auto;
        }

        #response .success {
            color: #28a745;
        }

        #response .error {
            color: #dc3545;
        }
    </style>

    <div id="response"></div>
@endsection
