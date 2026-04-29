@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Perkara</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('pengadilan') }}">Daftar Perkara</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pengadilan.show', ($data['data']['id'] ?? $data['id'])) }}">Detail</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4 shadow-sm border-warning">
        <div class="card-header bg-warning text-white">
            <i class="fas fa-edit me-1"></i> Form Edit Perkara
        </div>
        <div class="card-body">
            @php $perkara = $data['data'] ?? $data; @endphp
            
            <form action="{{ route('pengadilan.update', $perkara['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="no_perkara" class="form-label fw-bold">No. Perkara</label>
                    <input type="text" class="form-control" id="no_perkara" name="no_perkara" value="{{ $perkara['no_perkara'] ?? '' }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="jenis_perkara_id" class="form-label fw-bold">Jenis Perkara</label>
                    <select class="form-select" id="jenis_perkara_id" name="jenis_perkara_id" required>
                        <option value="" disabled>Pilih Jenis Perkara</option>
                        <!-- Options akan diisi via Axios -->
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pihak_p" class="form-label fw-bold">Pihak P (Penggugat)</label>
                        <input type="text" class="form-control" id="pihak_p" name="pihak_p" value="{{ $perkara['pihak_p'] ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hp_pihak_p" class="form-label fw-bold">HP Pihak P</label>
                        <input type="text" class="form-control" id="hp_pihak_p" name="hp_pihak_p" value="{{ $perkara['hp_pihak_p'] ?? '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pihak_t" class="form-label fw-bold">Pihak T (Tergugat)</label>
                        <input type="text" class="form-control" id="pihak_t" name="pihak_t" value="{{ $perkara['pihak_t'] ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hp_pihak_t" class="form-label fw-bold">HP Pihak T</label>
                        <input type="text" class="form-control" id="hp_pihak_t" name="hp_pihak_t" value="{{ $perkara['hp_pihak_t'] ?? '' }}" required>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <a href="{{ route('pengadilan.show', $perkara['id']) }}" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectJenisPerkara = document.getElementById('jenis_perkara_id');
        const token = "{{ session('token_api') }}";
        // ID jenis perkara yang tersimpan saat ini
        const selectedJenisId = "{{ $perkara['jenis_perkara_id'] ?? '' }}";
        
        axios.get('https://api-laperbang.pta-manado.go.id/api/jenisperkara', {
            headers: { 'Authorization': `Bearer ${token}` }
        })
        .then(response => {
            const listJenis = response.data.data;
            listJenis.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.jenis_perkara;
                
                // Tandai sebagai selected jika ID cocok
                if(item.id == selectedJenisId) {
                    option.selected = true;
                }
                
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
