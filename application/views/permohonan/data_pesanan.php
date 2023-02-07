<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-title"></h5>
          <div class="card-body">
            <table class="table" id="permohonan-data">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Kode Pesanan</th>
                      <th scope="col">Jenis Sample</th>
                      <th scope="col">Jumlah Sample</th>
                      <th scope="col">Nama Pemohon</th>
                      <th scope="col" width="10">Status</th>
                    </tr>
                  </thead>
                </table>
          </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  dataPesanan();
  function dataPesanan(){
      var dataTable = $('#permohonan-data').DataTable({  
         "processing":true,  
         "serverSide":true,  
         "order":[],  
         "ajax":{  
              url:"<?php echo base_url('permohonan/dataPesanan'); ?>",  
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