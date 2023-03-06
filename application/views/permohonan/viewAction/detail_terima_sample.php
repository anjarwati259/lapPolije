<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Data Permohonan</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <input type="hidden" id="id_permohonan" value="<?= $dataPermohonan->id ?>">
                <th style="width: 250px;">Kode Pesanan</th>
                <td>: <?= $dataPermohonan->no_pesanan ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Kirim</th>
                <td>: <?= dateDefault($dataPermohonan->tgl_kirim) ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Terima Sampel</th>
                <td style="display: flex;">:&nbsp;<input type="date" name="tgl_terima_sample" id="tgl_terima_sample" value="" class="form-control"></td>
              </tr>
              <tr>
                <th style="width: 250px;">Perkiraan Selesai (Hari)</th>
                <td style="display: flex;">:&nbsp;<input type="number" name="perkiraan_selesai" id="perkiraan_selesai" value="" class="form-control"></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Perkiraan Selesai</th>
                <td style="display: flex;">:&nbsp;<input type="date" name="tgl_perkiraan_selesai" id="tgl_perkiraan_selesai" value="" class="form-control"></td>
              </tr>
              <tr>
                <th style="width: 250px;">Tanggal Selesai</th>
                <td>: <?= ($dataPermohonan->tgl_selesai) ? ($dataPermohonan->tgl_selesai) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Jenis Sampel</th>
                <td>: <?= ($dataPermohonan->jenis_sample) ? ($dataPermohonan->jenis_sample) : '-' ?></td>
              </tr>
              <tr>
                <th style="width: 250px;">Jumlah Sampel</th>
                <td id="jml_sample">: <?= ($dataPermohonan->jml_sample) ? ($dataPermohonan->jml_sample) : '-' ?></td>
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
                    <td>: <?= ($dataPermohonan->instansi) ? ($dataPermohonan->instansi) : '-' ?></td>
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
          <?php for ($no_sampel=1; $no_sampel <= $dataPermohonan->jml_sample; $no_sampel++){ ?>
          <div class="card border-secondary">
            <h5 class="card-header"><b>No. Blanko:</b></h5>
            <div class="card-body">
              <table class="table table-striped" id="tbl">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Jenis Analisa</th>
                        <th scope="col">Metode Analisa</th>
                        <th scope="col">Nomor Sampel</th>
                        <th scope="col">Kode Sampel</th>
                        <th scope="col">Nama Analist</th>
                    </tr>
                </thead>
                <tbody style="border: none; border-color: #a6a8ab;">
                  <?php $no=1; foreach ($detailPermohonan as $key => $value) {
                        if($value->no_sample == $no_sampel){ 
                    ?>
                    <tr>
                      <th><?= $no++; ?></th>
                        <td><?= ($value->jenis_analisa) ? ($value->jenis_analisa) : '-' ?></td>
                        <td><?= ($value->metode_analisa) ? ($value->metode_analisa) : '-' ?></td>
                        <td><?= generateNomorSample($dataPermohonan->no_permohonan, $value->no_sample) ?></td>
                        <td>
                          <input class="form-control" type="text" name="kode_sample" id="kode_sample<?= $no_sampel; ?>" value="<?= generateKodeSample('kode_sample', $value->id_sampel) ?>" data-idsample="<?= $value->id_sampel ?>" readonly></td>
                        <td>
                          <select name="id_analist" id="id_analist" class="form-select" aria-label="Default select example" onchange="batasAnalist(this)">
                            <option selected disabled>Open this select menu</option>
                            <?php foreach ($dataAnalist as $kAnalist => $vAnalist) { 
                              if($vAnalist->jml_analist < $batas_analist){ ?>
                              <option value="<?= $vAnalist->id ?>"><?= $vAnalist->nama_pegawai ?></option>
                            <?php }} ?>
                          </select>
                        </td>
                        <input type="hidden" name="id" id="iddetail" value="<?= $value->id ?>">
                    </tr>
                  <?php } } ?>
                </tbody>
              </table>
              <div class="row">
                <label for="inputEmail3" class="col-sm-4 col-form-label"><b>Catatan:</b></label>
                <label><?= $detailPermohonan[$no_sampel]->catatan; ?></label>
              </div>
            </div>
          </div>
        <?php } ?>
          <div class="text-center">
            <button type="submit" class="btn btn-primary" onclick="simpanAdmin();">Submit</button>
            <a href="<?php echo base_url('admin/permohonan'); ?>" class="btn btn-danger">Cancel</a>
          </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  function simpanAdmin(){
    var tgl_terima_sample = $('#tgl_terima_sample').val();
    var tgl_perkiraan_selesai = $('#tgl_perkiraan_selesai').val();
    var id_permohonan = $('#id_permohonan').val();
    var perkiraan_selesai = $('#perkiraan_selesai').val();
    var dataAnalisa = {}
    var data = {}
    var jml_sample = parseInt('<?= $dataPermohonan->jml_sample ?>');
    var dataSample ={}
    var dataPermohonan = {['id'] : id_permohonan,
                          ['tgl_terima_sample'] : tgl_terima_sample,
                          ['tgl_perkiraan_selesai'] : tgl_perkiraan_selesai,
                          ['perkiraan_selesai'] : perkiraan_selesai}
    for (var i = 1; i <= jml_sample; i++) {
      var row = 0;
      let kode_sample = $("#tbl>tbody>tr").find('#kode_sample'+i).val();
      let id_sampel = $("#tbl>tbody>tr").find('#kode_sample'+i).attr("data-idsample");
      dataSample[i] = {['id']: id_sampel,
                        ['kode_sample'] : kode_sample}
    }

    $("#tbl>tbody>tr").each(function(index, val){
          let iddetail = $(this).find('#iddetail').val();
          let id_analist = $(this).find('#id_analist').val();
          dataAnalisa[index] = {['id'] : iddetail,
                      ['id_analist'] : id_analist};
    });
    data.data = dataAnalisa;
    // console.log(data)
    data.sample = dataSample;
    data.dataPermohonan = dataPermohonan;
    // console.log(data)
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url('permohonan/saveAnalist'); ?>",
      data:data,
      dataType : 'json',
      success: function(hasil) {
          console.log(hasil)
          var url = "<?php echo base_url('admin/permohonan'); ?>";
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

  function batasAnalist(sel){
    var id = sel.value;
    var data = {}
    var jmlAnalist = JSON.parse(localStorage.getItem("jmlAnalisa"));
    var batasAnalisa = '<?php echo $batas_analist; ?>'

    for(var key in jmlAnalist){
      var jml_analisa = parseInt(jmlAnalist[key].jml_analisa);
      if(jmlAnalist[key].id_analist == id && jml_analisa < batasAnalisa){
        jml_analisa+=1;
        jmlAnalist[key]['jml_analisa'] = jml_analisa;
      }
      if(jml_analisa >= batasAnalisa){
        var pesan = 'Analist dengan nama '+jmlAnalist[key].nama+' Telah Melebihi Batas';
        Swal.fire('Warning!',pesan,'warning');
      }
    }
    Object.assign(data,jmlAnalist);
    localStorage.setItem("jmlAnalisa",JSON.stringify(data));
    // var html = '<option>Coba</option>';
    // $("#tbl>tbody>tr").find('#id_analist').html(html);
  }

  setjmlAnalist()
  function setjmlAnalist(){
    let dataanalist = <?php echo json_encode($dataAnalist); ?>;
    // console.log(dataanalist)
    var jmlAnalist = {};
    for ( var key in dataanalist ) {
      jmlAnalist[key] = {['id_analist']:dataanalist[key].id, ['jml_analisa']:dataanalist[key].jml_analist, ['nama']:dataanalist[key].nama_pegawai}
    }
    localStorage.setItem("jmlAnalisa",JSON.stringify(jmlAnalist));
  }
</script>