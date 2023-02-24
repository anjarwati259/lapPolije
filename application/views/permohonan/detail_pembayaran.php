<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Data Permohonan</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <th style="width: 250px;">Kode Permohonan</th>
                <td>: <?= ($dataPermohonan->no_penawaran) ? ($dataPermohonan->no_permohonan) : ('-'); ?></td>
              </tr>
              <tr>
                <input type="hidden" id="id_permohonan" value="<?= $dataPermohonan->id ?>">
                <th style="width: 250px;">Kode Penawaran</th>
                <td>: <?= ($dataPermohonan->no_penawaran) ? ($dataPermohonan->no_penawaran) : ($noPenawaran); ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Kirim</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_kirim) ?></td>
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
                  <tr>
                    <th scope="row">Email</th>
                    <td>: <?= ($dataPermohonan->email) ? ($dataPermohonan->email) : '-' ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Alamat</th>
                    <td>: <?= ($dataPermohonan->alamat) ? ($dataPermohonan->alamat) : '-' ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div>

    <!-- <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Informasi Analisa Sample</h5>
          <table class="table table-striped" id="tbl-penawaran">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Analisa</th>
                <th scope="col">Metode Analisa</th>
                <th scope="col">Nomor Sampel</th>
                <th scope="col">Harga (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($detailPermohonan as $key => $value) {?>
              <tr>
                <th scope="row"><?= $no ?></th>
                <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
                <td><?= generateNomorSample($dataPermohonan->no_permohonan, $value->id_sampel) ?></td>
                <td id="harga" data-id ="<?= $value->id; ?>"><?= number_format($value->harga,0,',','.'); ?></td>
              </tr>
              <?php $no++;} ?>
            </tbody>
            <tfoot>
            	<tr>
            		<th colspan="4" class="text-end">Total</th>
            		<th id="total"><?= number_format($dataPermohonan->total_harga,0,',','.'); ?></th>
            	</tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div> -->

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Detail Pembayaran</h5>
          <table class="table table-striped" id="tbl-penawaran">
            <thead>
              <tr>
                <th scope="col">Tanggal Bayar</th>
                <th scope="col">Rekening</th>
                <th scope="col">Atas Nama</th>
                <th scope="col">Jumlah Bayar (Rp.)</th>
                <th scope="col">Dokumen</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?= dateDefault($dataBayar->tgl_bayar); ?></td>
                <td><?= $dataBayar->rekening; ?></td>
                <td><?= $dataBayar->atas_nama; ?></td>
                <td><?= number_format($dataBayar->jml_bayar,0,',','.'); ?></td>
                <td>
                  1. <a href="<?= base_url('permohonan/bukti_bayar/').urlencode(base64_encode($dataBayar->bukti_bayar)) ?>" target="_blank">Bukti Bayar</a><br>
                  2. <a href="<?= base_url('permohonan/invoice/').$dataPermohonan->id ?>">Invoive</a><br>
                  3. <a href="#">Kwitansi</a>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text-center group-button">
            <button type="button" class="btn btn-primary" onclick="AppBayar('approved')">Approved</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  function AppBayar(action){
    var id = $('#id_permohonan').val();
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('permohonan/AppBayar'); ?>",
        data:{id:id, action:action},
        dataType : 'json',
        success: function(hasil) {
            // console.log(hasil);
            var url = "<?php echo base_url('permohonan/kwitansi/'); ?>"+id;
            if(hasil.status == 'success'){
                localStorage.setItem("sukses",hasil.message)
                window.location.replace(url);
            }else{
                // localStorage.setItem("error",data.message)
                Swal.fire('Oppss...',hasil.message,'error')
            }
        }
    });
  }
</script>