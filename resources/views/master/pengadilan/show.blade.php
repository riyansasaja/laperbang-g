@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Perkara</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('pengadilan') }}">Daftar Perkara</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <div>
                <i class="fas fa-info-circle me-1 text-primary"></i>
                <strong>Informasi Detail Perkara</strong>
            </div>
            <a href="{{ route('pengadilan') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @php 
                // Cek apakah data dibungkus dalam key 'data' atau langsung array
                 $perkara = $data['perkara']['data'] ?? $data['perkara'];
                //  $jenisDokumen = $data['jenis_dokumen']['data'] ?? $data['jenis_dokumen'];
            @endphp
            
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-gavel me-2"></i>Data Perkara</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">No. Perkara</th>
                            <td>: {{ $perkara['no_perkara'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Perkara Banding</th>
                            <td>: <span class="badge bg-primary">{{ $perkara['nomor_perkara_banding'] ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <th>Jenis Perkara</th>
                            <td>: {{ $perkara['jenis_perkara'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tgl Permohonan</th>
                            <td>: {{ $perkara['tanggal_permohonan'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tgl Reg. Banding</th>
                            <td>: {{ $perkara['tanggal_reg_banding'] ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-users me-2"></i>Data Pihak</h5>
                    <table class="table table-sm table-borderless">
                        <tr class="bg-light">
                            <th width="40%">Pihak P (Penggugat)</th>
                            <td class="fw-bold">: {{ $perkara['pihak_p'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>HP Pihak P</th>
                            <td>: {{ $perkara['hp_pihak_p'] ?? '-' }}</td>
                        </tr>
                        <tr class="bg-light">
                            <th>Pihak T (Tergugat)</th>
                            <td class="fw-bold">: {{ $perkara['pihak_t'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>HP Pihak T</th>
                            <td>: {{ $perkara['hp_pihak_t'] ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>
            <div class="mt-3 text-muted small">
                <i class="fas fa-clock me-1"></i> Terakhir diperbarui: {{ date('d M Y H:i') }}
            </div>
            <hr>
            <div class="d-flex gap-2">
                <a href="{{ route('pengadilan.edit', $perkara['id']) }}" class="btn btn-warning text-white shadow-sm">
                    <i class="fas fa-edit me-1"></i> Edit Perkara
                </a>
                
              
            </div>
        </div>
    </div>

    {{-- upload dokumen --}}
    {{-- card baru --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <div>
                <i class="fas fa-file me-1 text-primary"></i>
                <strong>Upload Dokumen</strong>
            </div>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Tabel Upload Bundel A</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tableBundelA">
                    <thead class="table-primary">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Dokumen</th>
                            <th>Nama File</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['bundelA'] as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['nama_dokumen'] ?? $item['namadokumen'] }}</td>
                            <td>
                                <input type="file" class="form-control form-control-sm" id="file_{{ $item['id'] }}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm btn-upload" 
                                    data-id="{{ $item['id'] }}" 
                                    data-perkara="{{ $perkara['id'] }}">
                                    <i class="fas fa-upload me-1"></i> Upload
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.btn-upload').on('click', function() {
        const jenisDokumenId = $(this).data('id');
        const perkaraBandingId = $(this).data('perkara');
        const fileInput = $(`#file_${jenisDokumenId}`)[0];
        const btn = $(this);

        if (fileInput.files.length === 0) {
            Swal.fire('Peringatan', 'Silakan pilih file terlebih dahulu!', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        formData.append('jenis_dokumen_id', jenisDokumenId);
        formData.append('perkara_banding_id', perkaraBandingId);
        formData.append('_token', '{{ csrf_token() }}');

        // Disable button and show loading
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            url: "{{ route('dokumen.upload') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                btn.prop('disabled', false).html('<i class="fas fa-upload me-1"></i> Upload');
                if (response.success) {
                    Swal.fire('Berhasil', response.message, 'success');
                    fileInput.value = ''; // Reset file input
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-upload me-1"></i> Upload');
                let errorMsg = 'Terjadi kesalahan saat mengunggah dokumen.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', errorMsg, 'error');
            }
        });
    });
});
</script>
@endpush
@endsection
