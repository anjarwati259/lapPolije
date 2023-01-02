<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Data Permohonan</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <th style="width: 250px;">Kode Registrasi</th>
                <td>: <?= $dataPermohonan->kode_registrasi ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Kirim</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_kirim) ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Terima Sampel</th>
                <td>: <?= ($dataPermohonan->tgl_terima_sample) ? (dateDefault($dataPermohonan->tgl_terima_sample)) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Perkiraan Selesai</th>
                <td>: <?= ($dataPermohonan->tgl_perkiraan_selesai) ? (dateDefault($dataPermohonan->tgl_perkiraan_selesai)) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Selesai</th>
                <td>: <?= ($dataPermohonan->tgl_selesai) ? (dateDefault($dataPermohonan->tgl_selesai)) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Jenis Sampel</th>
                <td>: <?= ($dataPermohonan->jenis_sample) ? ($dataPermohonan->jenis_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Jumlah Sampel</th>
                <td>: <?= ($dataPermohonan->jml_sample) ? ($dataPermohonan->jml_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 200px;">Penyimpanan</th>
                <td>: <?= ($dataPermohonan->penyimpanan) ? ($dataPermohonan->penyimpanan) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">keterangan Sampel</th>
                <td>: <?= ($dataPermohonan->keterangan_sample) ? ($dataPermohonan->keterangan_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Status</th>
                <td>: <?= '<span class="badge '.$dataPermohonan->class_color.'">'.$dataPermohonan->keterangan.'</span>' ?></td>
              </tr>
            </tbody>
          </table>
          <!-- End Tables without borders -->

        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Pemohon</h5>
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th scope="row">Nama Pemohon</th>
                    <td>: <?= ($dataPermohonan->nama_customer) ? ($dataPermohonan->nama_customer) : '-' ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Nama Instansi</th>
                    <td>: -</td>
                  </tr>
                  <tr>
                    <th scope="row">Nomor Telephon</th>
                    <td>: <?= ($dataPermohonan->no_telp) ? ($dataPermohonan->no_telp) : '-' ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Daftar Dokumen</h5>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Kode Dokumen</th>
                    <th scope="col">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Brandon Jacob</td>
                    <td>Designer</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div>


    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Informasi Analisa Sample</h5>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Analisa</th>
                <th scope="col">Metode Analisa</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($detailPermohonan as $key => $value) {?>
              <tr>
                <th scope="row"><?= $no++ ?></th>
                <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <!-- End Tables without borders -->

        </div>
      </div>
    </div>
  </div>
</section>