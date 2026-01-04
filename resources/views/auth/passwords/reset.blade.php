<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card { border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-primary { background: linear-gradient(135deg, #e74c3c, #c0392b); border: none; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 450px;">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold">Buat Password Baru</h4>
                <p class="text-muted small">Silakan masukkan password baru Anda di bawah ini.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required readonly>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autofocus placeholder="Minimal 8 karakter">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label small fw-bold">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-check-double text-muted"></i></span>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Ulangi password">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary py-2 text-uppercase fw-bold text-white">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
