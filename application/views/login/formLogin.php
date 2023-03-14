<?php include(APPPATH.'views/layout/header.php'); ?>
<div class="container">

  <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="d-flex justify-content-between py-4">
            <a href="index.html" class="logo d-flex align-items-center w-auto">
              <img src="<?php echo base_url() ?>assets/image/logo-polije.png" alt="">
              <!-- <span class="d-none d-lg-block">Laboratorium Analisis</span> -->
            </a>
            <div class="d-flex">
              <img style="height: 40px;" src="<?php echo base_url() ?>assets/image/vokasi.png" alt="">
              <img style="height: 40px;" src="<?php echo base_url() ?>assets/image/BLU.png" alt="">
            </div>
          </div><!-- End Logo -->

          <div class="card mb-3">

            <div class="card-body">
              <!-- <div class="d-flex justify-content-between py-2">
                <img style="height: 40px;" src="<?php echo base_url() ?>assets/image/vokasi.png" alt="">
                <img style="height: 40px;" src="<?php echo base_url() ?>assets/image/BLU.png" alt="">
              </div> -->
              <div class="pt-2 pb-2 ">
                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                <p class="text-center small">Enter your username & password to login</p>
              </div>
              <!-- if success -->
              <?php if($this->session->flashdata('error')){ ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php } ?>
              <form action="<?php echo base_url('login') ?>" method="POST" class="row g-3 needs-validation" novalidate>

                <div class="col-12">
                  <label for="yourUsername" class="form-label">Username</label>
                  <div class="input-group has-validation">
                    <input type="text" name="username" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Please enter your username.</div>
                  </div>
                </div>

                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="yourPassword" required>
                  <div class="invalid-feedback">Please enter your password!</div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Login</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0">Don't have account? <a href="<?php echo base_url('login/register') ?>">Create an account</a></p>
                </div>
              </form>

            </div>
          </div>

          <div class="credits">
            Designed by <a href="#">POLIJE 2022</a>
          </div>

        </div>
      </div>
    </div>

  </section>

</div>
<?php include(APPPATH.'views/layout/footer.php'); ?>