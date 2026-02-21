@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-categories')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card mb-3">
                <div class="card-header">Detail Kategori</div>
                <div class="card-body">
                    <table class="table table-borderless w-auto">
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{$data->kode}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                    </table>
                    <a class="btn btn-success" href="{{url('master-categories/print')}}/{{$data->id}}">Cetak PDF</a>
                    <a class="btn btn-info" href="{{url('master-categories/form/edit')}}/{{$data->id}}">Edit</a>
                    <a class="btn btn-danger" href="{{url('master-categories/delete')}}/{{$data->id}}" onclick="return confirm('Are you sure you want to delete this kategori?');">Delete</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Daftar Item dalam Kategori Ini</div>
                <div class="card-body">
                    @if($data->items->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>View Item</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->items as $item)
                                <tr>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <a href="{{ url('master-items/view/' . $item->kode) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">Belum ada item dalam kategori ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
