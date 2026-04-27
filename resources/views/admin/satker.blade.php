@extends('admin.layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Satker</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Satker</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-building me-1"></i>
                Tabel Seluruh Satker
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSatkerModal">
                <i class="fas fa-plus"></i> Tambah Satker
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Satker</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        {{-- Antisipasi jika response API dibungkus dalam key 'data' atau langsung array --}}
                        @php $satkers = isset($data['data']) ? $data['data'] : (is_array($data) ? $data : []); @endphp
                        
                        @forelse($satkers as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $item['satker'] ?? '-' }}</td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-warning text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editSatkerModal{{ $item['id'] ?? '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal Edit Satker -->
                                    <div class="modal fade" id="editSatkerModal{{ $item['id'] ?? '' }}" tabindex="-1" aria-labelledby="editSatkerModalLabel{{ $item['id'] ?? '' }}" aria-hidden="true">
                                      <div class="modal-dialog text-start">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="editSatkerModalLabel{{ $item['id'] ?? '' }}">Form Edit Satker</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form action="{{ route('admin.satker.update', $item['id'] ?? '') }}" method="POST">
                                              @csrf
                                              @method('PUT')
                                              <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama_satker_{{ $item['id'] ?? '' }}" class="form-label">Nama Satker</label>
                                                    <input type="text" class="form-control" id="nama_satker_{{ $item['id'] ?? '' }}" name="nama_satker" value="{{ $item['satker'] ?? '' }}" required>
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update Satker</button>
                                              </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <!-- Tombol Delete -->
                                    <form action="{{ route('admin.satker.delete', $item['id'] ?? '') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus satker ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data yang ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Satker -->
<div class="modal fade" id="addSatkerModal" tabindex="-1" aria-labelledby="addSatkerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSatkerModalLabel">Form Add Satker</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.satker.create') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
                <label for="nama_satker" class="form-label" >Nama Satker</label>
                <input type="text" class="form-control" id="nama_satker" name="nama_satker" placeholder="Nama Satker" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Satker</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
