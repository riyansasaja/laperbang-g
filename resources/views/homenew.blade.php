
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cover</title>
	<!-- Bootstrap 5 CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #212529;
			color: #fff;
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}
		   .cover-container {
			   text-align: center;
			   margin: auto;
		   }
		   @media (min-width: 768px) {
			   .cover-container {
				   max-width: 60vw;
				   padding: 2rem;
			   }
		   }
		.nav-link.active {
			border-bottom: 2px solid #fff;
		}
		footer {
			color: #adb5bd;
		}
	</style>
</head>
<body>
	<header class="mb-auto">
		<div>
			<nav class="navbar navbar-expand-lg navbar-dark">
				<div class="container-fluid justify-content-between">
					<a class="navbar-brand fw-bold" href="#">LAPERBANG</a>
					<div>
						<a href="#" class="btn btn-light fw-semibold px-4 py-2">Login</a>
					</div>
				</div>
			</nav>
		</div>
	</header>

	<main class="cover-container d-flex flex-column justify-content-center align-items-center flex-grow-1 px-3 px-md-0">
		<h1 class="display-5 fw-bold mb-3 text-break text-center">Selamat Datang !</h1>
		<h3 class="fw-bold mb-3 text-break text-center">Aplikasi Layanan Perkara Banding</h3>
		<p class="lead mb-4 text-center">Untuk mencari informasi, silahkan inputkan nomor perkara banding di bawah ini</p>
		<form class="row row-cols-1 row-cols-md-auto g-2 justify-content-center align-items-center mb-3 w-100" method="post" action="{{ route('search') }}" style="max-width: 100%;">
			@csrf
			<div class="col mb-2 mb-md-0">
				<input type="number" class="form-control" name="nomor_perkara" placeholder="Nomor Perkara" required>
			</div>
			<div class="col mb-2 mb-md-0">
				<input type="number" class="form-control" name="tahun_perkara" placeholder="Tahun" min="2024" max="2030"  required>
			</div>
			<div class="col">
				<button type="submit" class="btn btn-light fw-semibold w-100 w-md-auto">Cari</button>
			</div>
		</form>
	</main>

	<footer class="mt-auto text-center py-3">
		Cover template for <a href="https://getbootstrap.com/" class="text-decoration-underline text-light">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-decoration-underline text-light">@mdo</a>.
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	@if(session('error'))
	<script>
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: '{{ session("error") }}',
			confirmButtonColor: '#3085d6',
		});
	</script>
	@endif

	<script>
		// Animasi loading saat form disubmit
		document.querySelector('form').addEventListener('submit', function() {
			Swal.fire({
				title: 'Mencari Data...',
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

