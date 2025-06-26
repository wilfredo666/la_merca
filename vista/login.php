<body class="hold-transition login-page">
  <div id="back"></div>
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
       
          <h4 class="login-box-msg">Sistema La Merca</h4>
        

        <form action="#" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Login de usuario" name="usuario" id="usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese su contraseña">
            <div class="input-group-append">
              <div class="input-group-text" id="toggle-password">
                <!--<span class="fas fa-lock"></span>-->

                <span class="fas fa-eye" id="toggle-password-icon"></span>

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Acceder</button>
            </div>
            <!-- /.col -->
          </div>
          <?php
          $login = new ControladorUsuario();
          $login->ctrIngresoUsuario();
          ?>

        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="assest/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assest/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assest/dist/js/adminlte.min.js"></script>

  <script>
    document.getElementById('toggle-password').addEventListener('click', function (e) {
      const passwordInput = document.getElementById('password');
      const passwordIcon = document.getElementById('toggle-password-icon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
      }
    });
  </script>
</body>

</html>