@extends('layouts.dashboard')

@section('title','Kelola Paket')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Paket</h1>

    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        data-toggle="modal"
        data-target="#modalTambah">

        <i class="fas fa-plus fa-sm text-white-50"></i>
        Tambah Paket
    </button>
</div>

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data Paket Layanan
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($paket as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}</td>

                        <td>
                            <span class="badge badge-info">
                                {{ ucfirst($item->category) }}
                            </span>
                        </td>

                        <td>
                            Rp {{ number_format($item->price,0,',','.') }}
                        </td>

                        <td>
                            {{ $item->duration }} Menit
                        </td>

                        <td>

                            <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#edit{{ $item->id }}">

                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ url('/admin/hapus-paket/'.$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Hapus paket ini?')"
                                        class="btn btn-danger btn-sm">

                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </td>

                    </tr>
                    <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ url('/admin/edit-paket/'.$item->id) }}" method="POST">
                                @csrf

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Paket</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Nama Paket</label>
                                        <input type="text" name="name" value="{{ $item->name }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="category" class="form-control">
                                            <option value="tarot" {{ $item->category=='tarot'?'selected':'' }}>Tarot</option>
                                            <option value="palm" {{ $item->category=='palm'?'selected':'' }}>Palm</option>
                                            <option value="chat" {{ $item->category=='chat'?'selected':'' }}>Chat</option>
                                            <option value="call" {{ $item->category=='call'?'selected':'' }}>Call</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="number" name="price" value="{{ $item->price }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Durasi</label>
                                        <input type="number" name="duration" value="{{ $item->duration }}" class="form-control">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">Update</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Data paket kosong
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ url('/admin/tambah-paket') }}" method="POST">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Paket</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Nama Paket</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" class="form-control">
                        <option value="tarot">Tarot</option>
                        <option value="palm">Palm</option>
                        <option value="palm">Chat</option>
                        <option value="palm">Call</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control">
                </div>

                <div class="form-group">
                    <label>Durasi</label>
                    <input type="number" name="duration" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>

            </form>

        </div>
    </div>
</div>

@endsection