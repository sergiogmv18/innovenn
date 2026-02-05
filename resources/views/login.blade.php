<!DOCTYPE html>
<html lang="es">
  @include('clients.components.head', ['title'=>'Registro de Viajeros'])

  <style>
    html, body {
      height: 100%;
      font-family: var(--current-font-family-body);
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: var(--current-font-family-title);
    }

    /* Fondo estilo SaaS */
    body {
      background: radial-gradient(circle at 50% 20%, #e8f1ff 0%, #f7fbff 45%, #ffffff 100%);
    }

    /* Wrapper centrado vertical */
    .login-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    /* Card moderna */
    .login-card {
      width: 100%;
      max-width: 520px;
      border-radius: 18px;
      overflow: hidden;
    }

    .login-card .card-content {
      padding: 34px 34px 26px 34px;
    }

    .login-title {
      font-weight: 800;
      margin: 12px 0 4px 0;
    }

    .login-subtitle {
      margin: 0 0 18px 0;
      color: rgba(0,0,0,.55);
      font-size: 15px;
    }

    /* Inputs tipo pill */
    .input-pill {
      background: #ffffff;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: 14px;
      padding: 8px 12px 2px 12px;
      box-shadow: 0 8px 18px rgba(0,0,0,.04);
    }

    .input-pill .input-field {
      margin: 0;
    }

    .input-pill .input-field .prefix {
      color: rgba(0,0,0,.45);
    }

    /* Estilo focus consistente (limpio, sin reglas duplicadas) */
    .input-field input:focus {
      border-bottom: 1px solid rgb(100, 181, 246) !important;
      box-shadow: 0 1px 0 0 rgb(100, 181, 246) !important;
    }
    .input-field input:focus + label {
      color: rgb(100, 181, 246) !important;
    }
    .input-field .prefix.active {
      color: var(--color-button);
    }

    /* Botón más pro */
    .login-btn {
      width: 100%;
      border-radius: 12px;
      height: 52px;
      line-height: 52px;
      font-weight: 700;
      letter-spacing: .3px;
      background-color: var(--color-button);
    }

    .forgot-link {
      display: inline-block;
      margin-top: 14px;
      color: rgb(25, 118, 210);
      font-weight: 600;
    }
  </style>

  <body>
    <div class="login-wrap">
      <div class="card login-card white z-depth-2">
        <div class="card-content center-align">

          {{-- Opcional: tu logo --}}
          {{-- <img src="{{ asset('tu-logo.png') }}" alt="Logo" style="height:34px; margin-bottom:10px;"> --}}

          <h4 class="login-title">Iniciar sesión</h4>
          <p class="login-subtitle">Accede al panel</p>

          <form action="{{ route('signIn') }}">
            @csrf
            <div class="input-pill">
              <div class="input-field">
                <i class="material-icons prefix">person</i>
                <input name="email_address" type="email" id="userName" class="validate" required autocomplete="username" />
                <label for="userName">Nombre de usuario</label>
              </div>
            </div>

            <div style="height:14px;"></div>

            <div class="input-pill">
              <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input name="password" type="password" id="userPassword" class="validate" required autocomplete="current-password" />
                <label for="userPassword">Contraseña</label>
              </div>
            </div>

            <div style="height:18px;"></div>
            
            <button class="btn waves-effect waves-light login-btn" type="submit">
              Entrar
            </button>

            {{-- Opcional --}}
            <!-- <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a> -->
          </form>

        </div>
      </div>
    </div>

    @include('clients.components.scripts')
  </body>
</html>
