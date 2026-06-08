@extends('layouts.dashboard')

@section('title','Kelola User')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola User</h1>

    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        data-toggle="modal"
        data-target="#modalTambahUser">
        <i class="fas fa-plus fa-sm text-white-50"></i>
        Tambah User
    </button>
</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            @if($item->role == 'admin')
                                <span class="badge badge-danger">Admin</span>
                            @elseif($item->role == 'reader')
                                <span class="badge badge-success">Reader</span>
                            @else
                                <span class="badge badge-primary">Customer</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#modalEditUser{{ $item->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ url('/admin/users/'.$item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus user ini?')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- MODAL EDIT USER --}}
                    <div class="modal fade" id="modalEditUser{{ $item->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ url('/admin/users/update/'.$item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5>Edit User</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control mb-2" value="{{ $item->name }}" required>
                                        
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control mb-2" value="{{ $item->email }}" required>

                                        {{-- INPUT PASSWORD BARU (Kunci Fleksibel) --}}
                                        <label>Password Baru</label>
                                        <input type="password" name="password" class="form-control mb-1" placeholder="Masukkan password baru">
                                        <small class="text-muted d-block mb-3">*Kosongkan jika tidak ingin mengganti password</small>

                                        <label>Role</label>
                                        <select name="role" class="form-control">
                                            <option value="customer" {{ $item->role == 'customer' ? 'selected' : '' }}>Customer</option>
                                            <option value="reader" {{ $item->role == 'reader' ? 'selected' : '' }}>Reader</option>
                                            <option value="admin" {{ $item->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data user kosong</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="modalTambahUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/admin/users/store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                    <select name="role" class="form-control">
                        <option value="customer">Customer</option>
                        <option value="reader">Reader</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection