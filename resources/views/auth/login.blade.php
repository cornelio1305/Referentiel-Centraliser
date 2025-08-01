<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a2d0a6a64b.js" crossorigin="anonymous"></script>
  <style>
    body {
      background: linear-gradient(135deg, #fff176, #fff59d);
      height: 100vh;
    }

    .login-card {
      border: 2px solid #dc3545;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2);
      background-color: white;
    }

    .logo-circle {
      width: 100px;
      height: 100px;
      background: white;
      border: 4px solid #dc3545;
      border-radius: 50%;
      overflow: hidden;
      margin: 30px auto 10px auto;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }

    .logo-circle img {
      width: 90%;
      height: 90%;
      object-fit: cover;
      border-radius: 50%;
    }

    .btn-theme {
      background-color: #dc3545;
      border: none;
      color: white;
      font-weight: bold;
    }

    .btn-theme:hover {
      background-color: #c82333;
    }

    .card-title {
      color: #dc3545;
      font-weight: bold;
      text-shadow: 1px 1px rgba(0, 0, 0, 0.1);
    }

    .alert-danger {
      border-left: 5px solid #dc3545;
      background-color: rgba(220, 53, 69, 0.1);
    }

    .form-label {
      font-weight: 500;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <!-- Logo circulaire -->
        <div class="logo-circle">
          <img src="{{ asset('images/ceet_officiel_logo-removebg-preview.png') }}" alt="Logo"
               onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
          <i class="fas fa-building fa-3x text-danger" style="display: none;"></i>
        </div>

        <!-- Carte de connexion -->
        <div class="card login-card">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Connexion</h3>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" required autofocus>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password" required>
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" title="Afficher/Masquer le mot de passe">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                  </button>
                </div>
              </div>

              <button type="submit" class="btn btn-theme w-100">Se connecter</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }
  </script>

</body>
</html>
