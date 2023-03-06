<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-body">
            <div class="card-title text-right">
              <button type="button" class="btn btn-sm btn-success">Download Excel</button>
            </div>
            <table class="table" id="laporan_permohonan-data">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">No. Pesanan</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Nama Customer</th>
                  <th scope="col">Jenis Sample</th>
                  <th scope="col">Kode Sample</th>
                  <th scope="col">Jenis Analisa</th>
                  <th scope="col">Metode Analisa</th>
                  <th scope="col">Harga</th>
                </tr>
              </thead>
            </table>
          </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  dataLapPermohonan();
  function dataLapPermohonan(){
      var dataTable = $('#laporan_permohonan-data').DataTable({  
         "processing":true,  
         "serverSide":true,  
         "order":[],  
         "ajax":{  
              url:"<?php echo base_url('permohonan/getLapPermohonan'); ?>",
              type:"POST"  
         },  
         "columnDefs":[  
              {  
                   "targets":[0],  // sesuaikan order table dengan jumlah column
                   "orderable":false,  
              },  
         ],  
    });
  }
</script>