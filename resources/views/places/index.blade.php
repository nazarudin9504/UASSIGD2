@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
<style>
    .table td, .table th {
        padding: 8px;
        text-align: center;
        vertical-align: middle;
    }
    .option-buttons a, .option-buttons form {
        display: inline-block;
        margin: 2px;
    }
    .option-buttons form {
        margin: 0;
    }
    .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        margin-right: 2px;
    }
    .btn-info {
        color: #fff !important;
        margin-right: 2px;
    }
    .image-cell img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px; /* Make the corners rounded but not circular */
    }

    
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                @include('notify::components.notify')
                <div class="card-header">Daftar Tempat</div>
                <div class="card-body">
                    <a href="{{ route('places.create') }}" class="btn btn-primary btn-sm float-right mb-2">Tambah tempat</a>
                    <table class="table table-hover" id="tablePlace">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Place Name</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($places as $key => $place)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $place->place_name }}</td>
                                <td>{{ $place->address }}</td>
                                <td>{{ $place->description }}</td>
                                <td class="image-cell">
                                    <img src="{{ asset('storage/' . $place->image) }}" alt="{{ $place->place_name }}">
                                </td>
                                <td class="option-buttons">
                                    <a href="{{ route('places.show', $place->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('places.edit', $place->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('places.destroy', $place->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>0
<form action="" method="post" id="deleteForm">
    @csrf
    @method("DELETE")
    <input type="submit" value="Hapus" style="display:none">
</form>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablePlace').DataTable();
    });
</script>
@endpush
