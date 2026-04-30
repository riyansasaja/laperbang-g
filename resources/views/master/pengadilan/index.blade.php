@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Perkara Banding</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Perkara</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div>
            <i class="fas fa-table me-1"></i>
            Daftar Perkara
            </div>
            <div>
            <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPerkara">Tambah Perkara</button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover" id="datatablesSimple" >
                <thead class="table-dark">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>No Perkara</th>
                        <th>No. Perkara Banding</th>
                        <th>Tgl Permohonan</th>
                        <th>Tgl Reg. Banding</th>
                        <th>Status Perkara</th>
                        <th width="12%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        // Cek apakah data dibungkus dalam key 'data' (standar API) atau langsung array
                        $perkaraList = $data['data'] ?? $data; 
                    @endphp
                    
                    @if(is_array($perkaraList) || is_object($perkaraList))
                        @forelse($perkaraList as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item['no_perkara'] ?? '-' }}</td>
                                <td>{{ $item['nomor_perkara_banding'] ?? '-' }}</td>
                                <td>{{ $item['tanggal_permohonan'] ?? '-' }}</td>
                                <td>{{ $item['tanggal_reg_banding'] ?? '-' }}</td>
                                <td>{{ $item['status'] ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pengadilan.show', $item['id']) }}" class="btn btn-sm btn-info text-white" title="View Detil">
                                        <i class="fas fa-eye"></i> Detil
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data perkara yang ditemukan.</td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Format data tidak sesuai atau gagal memuat data.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- modal addperkara --}}
<!-- Modal -->
<div class="modal fade" id="addPerkara" tabindex="-1" aria-labelledby="addPerkara" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('pengadilan.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addPerkaraLabel">Tambah Perkara</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="no_perkara" class="form-label">No. Perkara</label>
            <input type="text" class="form-control" id="no_perkara" name="no_perkara" placeholder="Contoh: 123/Pdt.G/2024/PA.Mdo" required>
          </div>
          
          <div class="mb-3">
            <label for="jenis_perkara_id" class="form-label">Jenis Perkara</label>
            <select class="form-select" id="jenis_perkara_id" name="jenis_perkara_id" required>
              <option value="" selected disabled>Pilih Jenis Perkara</option>
              <!-- Options akan diisi via Axios -->
              <!-- Anda bisa menyesuaikan options ini dengan data dari database -->
            </select>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="pihak_p" class="form-label">Pihak P (Penggugat)</label>
              <input type="text" class="form-control" id="pihak_p" name="pihak_p" placeholder="Nama Penggugat" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="hp_pihak_p" class="form-label">HP Pihak P</label>
              <input type="text" class="form-control" id="hp_pihak_p" name="hp_pihak_p" placeholder="Contoh: 0812..." required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="pihak_t" class="form-label">Pihak T (Tergugat)</label>
              <input type="text" class="form-control" id="pihak_t" name="pihak_t" placeholder="Nama Tergugat" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="hp_pihak_t" class="form-label">HP Pihak T</label>
              <input type="text" class="form-control" id="hp_pihak_t" name="hp_pihak_t" placeholder="Contoh: 0812..." required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perkara</button>
        </div>
      </div>
    </form>
  </div>
</div>



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectJenisPerkara = document.getElementById('jenis_perkara_id');
        // Ambil token dari session Laravel ke JavaScript
        const token = "{{ session('token_api') }}";
        
        axios.get('https://api-laperbang.pta-manado.go.id/api/jenisperkara', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            const listJenis = response.data.data;            
            listJenis.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id; // berisi "jR", "k5", dll
                option.textContent = item.jenis_perkara; // berisi "Cerai Talak", dll
                selectJenisPerkara.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Gagal mengambil data jenis perkara:', error);
        });
    });
</script>
@endpush


@endsection
