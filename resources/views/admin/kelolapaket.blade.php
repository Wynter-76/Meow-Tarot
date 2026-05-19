@extends('layouts.dashboard')

@section('title','Kelola Paket')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Paket</h1>

    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        data-toggle="modal"
        data-target="#modalTambah">
        <i class="fas fa-plus fa-sm text-white-50"></i>
        Tambah Paket
    </button>
</div>

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
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Limit Tanya</th>
                        <th>Durasi</th>
                        <th>Deskripsi</th>
                        <th width="120">Aksi</th>
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
                            @if($item->is_online == 1)
                                <span class="badge badge-success">Online</span>
                            @elseif($item->is_offline == 1)
                                <span class="badge badge-secondary">Offline</span>
                            @else
                                <span class="badge badge-light">-</span>
                            @endif
                        </td>
                        <td>
                            Rp {{ number_format($item->price,0,',','.') }}
                        </td>
                        <td>
                            {{ $item->question_limit ?? '-' }}
                        </td>
                        <td>
                            {{ $item->duration ? $item->duration . ' Menit' : '-' }}
                        </td>
                        <td>
                            <small class="text-muted">{{ Str::limit($item->description, 40, '...') ?? '-' }}</small>
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
                                        <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
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
                                        <label>Tipe Layanan</label>
                                        <select name="layanan_type" class="form-control">
                                            <option value="online" {{ $item->is_online == 1 ? 'selected' : '' }}>Online</option>
                                            <option value="offline" {{ $item->is_offline == 1 ? 'selected' : '' }}>Offline</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="number" name="price" value="{{ $item->price }}" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Limit Pertanyaan (Khusus Tarot)</label>
                                        <input type="number" name="question_limit" value="{{ $item->question_limit }}" class="form-control" placeholder="Boleh kosong jika tidak ada limit">
                                    </div>

                                    <div class="form-group">
                                        <label>Durasi (Menit)</label>
                                        <input type="number" name="duration" value="{{ $item->duration }}" class="form-control" placeholder="Boleh kosong jika tidak pakai durasi">
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi Paket</label>
                                        <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
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
                        <td colspan="9" class="text-center">Data paket kosong</td>
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
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" class="form-control">
                        <option value="tarot">Tarot</option>
                        <option value="palm">Palm</option>
                        <option value="chat">Chat</option>
                        <option value="call">Call</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipe Layanan</label>
                    <select name="layanan_type" class="form-control">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Limit Pertanyaan (Khusus Tarot)</label>
                    <input type="number" name="question_limit" class="form-control" placeholder="Contoh: 1, 2, atau 3">
                </div>

                <div class="form-group">
                    <label>Durasi (Menit)</label>
                    <input type="number" name="duration" class="form-control" placeholder="Contoh: 15, 30, atau 60">
                </div>

                <div class="form-group">
                    <label>Deskripsi Paket</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan keterangan isi paket di sini..."></textarea>
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