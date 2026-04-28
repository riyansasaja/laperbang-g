<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LAPERBANG</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800">Welcome Back</h2>
            <p class="text-gray-500 mt-2 text-sm">Silakan login ke akun LAPERBANG Anda</p>
        </div>

        <form action="{{ url('api/login') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 outline-none transition-colors" placeholder="Masukkan username" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 outline-none transition-colors" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300">
                Sign In
            </button>
            
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">← Kembali ke Beranda</a>
            </div>
        </form>
    </div>

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '{{ session("error") }}',
            confirmButtonColor: '#3085d6',
            background: '#fff',
            borderRadius: '1rem',
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success") }}',
            confirmButtonColor: '#3085d6',
            background: '#fff',
            borderRadius: '1rem',
        });
    </script>
    @endif  

    <script>
		// Animasi loading saat form disubmit
		document.querySelector('form').addEventListener('submit', function() {
			Swal.fire({
				title: 'Loading...',
				html: 'Mohon tunggu sebentar.',
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});
		});
	</script>
</body>
</html>
