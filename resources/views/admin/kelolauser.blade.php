@extends('layouts.dashboard')

@section('title','Kelola User')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola User</h1>

    <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        data-toggle="modal"
        data-target="#modalTambahUser">
    
    <i class="fas fa-plus fa-sm text-white-50"></i>
    Tambah User
</button>
</div>

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data User
        </h6>
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

                            <button class="btn btn-warning btn-sm btn-edit"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-email="{{ $item->email }}"
                                data-role="{{ $item->role }}"
                                data-toggle="modal"
                                data-target="#modalEditUser">

                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ url('/admin/users/'.$item->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Hapus user ini?')"
                                        class="btn btn-danger btn-sm">

                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </td>
                    </tr>
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
                                <button class="btn btn-primary">Simpan</button>
                                </div>

                            </form>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalEditUser">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <form id="formEditUser" method="POST">
                                @csrf

                                <div class="modal-header">
                                <h5>Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">

                                <input type="text" name="name" id="edit-name" class="form-control mb-2" placeholder="Nama">
                                <input type="email" name="email" id="edit-email" class="form-control mb-2" placeholder="Email">

                                <select name="role" id="edit-role" class="form-control">
                                    <option value="customer">Customer</option>
                                    <option value="reader">Reader</option>
                                    <option value="admin">Admin</option>
                                </select>

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
                        <td colspan="5" class="text-center">
                            Data user kosong
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection