@extends('admin.layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data User</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Tabel Seluruh User
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        {{-- Antisipasi jika response API dibungkus dalam key 'data' atau langsung array --}}
                        @php $users = isset($data['data']) ? $data['data'] : $data; @endphp
                        
                        @forelse($users as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item['name'] ?? '-' }}</td>
                                <td>{{ $item['email'] ?? '-' }}</td>
                                <td>
                                    @if(isset($item['role']) && $item['role'] == 'superadmin')
                                        <span class="badge bg-danger">{{ $item['role'] }}</span>
                                    @elseif(isset($item['role']) && $item['role'] == 'admin')
                                        <span class="badge bg-primary">{{ $item['role'] }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item['role'] ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Detil -->
                                    <button class="btn btn-sm btn-info text-white" title="Detil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <!-- Tombol Delete -->
                                    <button class="btn btn-sm btn-danger text-white" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data yang ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection