@extends('layouts.dashboard')

@section('title','Kelola Testimonial')

@section('content')

<!-- Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Testimonial</h1>
</div>

<!-- Alert -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Card -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data Testimoni Customer
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" width="100%">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Pesan</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($data as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->user->name ?? '-' }}</td>

                        <td>{{ $item->message }}</td>

                        <td>
                            @if($item->is_approved)
                                <span class="badge badge-success">
                                    Approved
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td>

                            @if(!$item->is_approved)
                                <a href="{{ url('/admin/testimonial/approve/'.$item->id) }}"
                                   class="btn btn-success btn-sm">
                                    Approve
                                </a>
                            @endif

                            <!-- DELETE -->
                            <form action="{{ url('/admin/testimonial/'.$item->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin mau hapus?')">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada testimoni
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection