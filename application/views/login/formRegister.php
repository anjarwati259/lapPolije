<?php include(APPPATH.'views/layout/header.php'); ?>
<div class="container">

  <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="d-flex justify-content-center py-4">
            <a href="index.html" class="logo d-flex align-items-center w-auto">
              <img src="<?php echo base_url() ?>template/NiceAdmin/assets/img/logo.png" alt="">
              <span class="d-none d-lg-block">NiceAdmin</span>
            </a>
          </div><!-- End Logo -->

          <div class="card mb-3">

            <div class="card-body">

              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                <p class="text-center small">Enter your personal details to create account</p>
              </div>

              <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                <div class="col-6">
                  <label for="yourName" class="form-label">Nama Lengkap</label>
                  <input type="text" name="name" class="form-control" id="yourName" required>
                  <div class="invalid-feedback">Please, enter your name!</div>
                </div>

                <div class="col-6">
                  <label for="yourName" class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" id="username" required>
                  <div class="invalid-feedback">Please, enter your Username!</div>
                </div>

                <div class="col-6">
                  <label for="yourEmail" class="form-label">Your Email</label>
                  <input type="email" name="email" class="form-control" id="yourEmail" required>
                  <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                </div>

                <div class="col-6">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="password" required>
                  <div class="invalid-feedback">Please enter your password!</div>
                  <div id="msgPass"></div>
                </div>

                <div class="col-6">
                  <label for="yourName" class="form-label">Nomor Telephon (WA)</label>
                  <input type="number" name="no_telp" class="form-control" id="no_telp" required>
                  <div class="invalid-feedback">Please, enter your phone!</div>
                </div>

                <div class="col-6">
                  <label for="rep_pass" class="form-label">Ulangi Password</label>
                  <input type="password" name="rep_pass" class="form-control" id="rep_pass" required>
                  <div class="invalid-feedback">Please, enter your password!</div>
                  <div id="msgRep"></div>
                </div>

                <div class="col-12">
                  <label for="yourName" class="form-label">Alamat</label>
                  <textarea class="form-control" name="alamat" id="alamat" style="height: 100px;" required></textarea>
                  <div class="invalid-feedback">Please, enter your Address!</div>
                </div>

                <div class="col-12 text-end">
                  <button class="btn btn-primary w-30" type="submit">Create Account</button>
                </div>
                <div class="col-12 text-end">
                  <p class="small mb-0">Already have an account? <a href="<?php echo base_url('login') ?>">Log in</a></p>
                </div>
              </form>

            </div>
          </div>

          <div class="credits">
            Designed by <a href="#">Polije 2022</a>
          </div>

        </div>
      </div>
    </div>

  </section>

</div>
<?php include(APPPATH.'views/layout/footer.php'); ?>

<script type="text/javascript">
  $('#password, #rep_pass').on('keyup', function () {
    if ($('#password').val() == $('#rep_pass').val()) {
      $('#msgRep').html('Password Matching').css('color', 'green');
    } else {
      $('#msgRep').html('Password Not Matching').css('color', 'red');
    }
  });

  $('#password').on('keyup', function () {
    var password = $('#password').val();
    var panjang = password.length;
    if(panjang < 6){
      $('#msgPass').html('Panjang Password Minimal 6 Karakter').css('color', 'red');
    }else{
      $('#msgPass').html('').css('color', 'red');
    }
  });
</script>