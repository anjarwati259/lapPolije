<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-md-4">
          <div class="card info-card revenue-card">

            <div class="card-body">
              <h5 class="card-title">Total Permohonan</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6><?= ($total) ? ($total) : (0) ?></h6>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <!-- <div class="col-md-4">
          <div class="card info-card revenue-card">

            <div class="card-body">
              <h5 class="card-title">Total Order</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6>$3,264</h6>

                </div>
              </div>
            </div>

          </div>
        </div> -->
        <!-- End Revenue Card -->
        <!-- Revenue Card -->
        <div class="col-md-4">
          <div class="card info-card revenue-card">

            <div class="card-body">
              <h5 class="card-title">Total Pendapatan</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6>Rp. <?= ($pendapatan) ? (number_format($pendapatan, 0, ',','.')) : (0) ?></h6>

                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-md-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">Pengumuman</h5>

              <?= ($dashboard->content) ? ($dashboard->content) : (''); ?>

            </div>
          </div>

        </div><!-- End Customers Card -->

      </div>
    </div><!-- End Left side columns -->

  </div>
</section>