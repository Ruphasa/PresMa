<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PresMa : Daftar</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h3>Register</h3>
                                </div>
                            </div>
                        </div>

                        <form action="{{ url('register') }}" method="POST">
                            @csrf

                            <!-- Default gambar -->
                            <input type="hidden" name="img" value="default.jpg">

                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama lengkap" required>
                                </div>
                            </div>
                            <br>

                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <br>

                            <div class="row gy-3 gy-md-4">
                                <div class="col-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="col-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                </div>
                            </div>
                            <br>

                            <div class="row gy-3 gy-md-4">
                                <div class="col-12">
                                    <label for="level_id" class="form-label">Level <span class="text-danger">*</span></label>
                                    <select name="level_id" id="level_id" class="form-select" required>
                                        <option value="">-- Pilih Level --</option>
                                        <option value="1">Mahasiswa</option>
                                        <option value="2">Dosen</option>
                                        <option value="3">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="row gy-3 gy-md-4">
                                <div class="d-grid">
                                    <button class="btn btn-lg btn-primary" type="submit">Register</button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                    <a href="{{ url('login') }}" class="link-secondary text-decoration-none">Login</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
