<div class="card">
    <div class="card-body">
      <table class="table" id="user-data">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">NIP</th>
                <th scope="col">Nama User</th>
                <th scope="col">Username</th>
                <th scope="col">Hak Akses</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
          </table>
    </div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User Hak Akses</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <input type="hidden" id="id_user">
            <tr>
              <td>NIP</td>
              <td>:</td>
              <td id="nip"></td>
            </tr>
            <tr>
              <td>Nama User</td>
              <td>:</td>
              <td id="nama_user"></td>
            </tr>
            <tr>
              <td>Hak Akses</td>
              <td>:</td>
              <td id="hak_akses">
                <select name="id_role" id="id_role" class="form-select" aria-label="Default select example">
                  <option selected disabled>Open this select menu</option>
                  <?php foreach ($role as $key => $value) {?>
                  <option value="<?= $value->id ?>"><?= $value->role_name ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="Submit()">Simpan</button>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
  var pesan = localStorage.getItem("sukses");
  if(pesan)
  {
      Swal.fire('Success',pesan,'success')
      localStorage.removeItem('sukses');
  }
  dataCustomer();

  function dataCustomer(){
      var dataTable = $('#user-data').DataTable({  
         "processing":true,  
         "serverSide":true,  
         "order":[],  
         "ajax":{  
              url:"<?php echo base_url('admin/getManagementUser'); ?>",  
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

  function edituser(id){
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url('admin/getUserById'); ?>",
      data:{id:id},
      dataType : 'json',
      success: function(hasil) {
        console.log(hasil); 
        $('#id_user').val(hasil.id);
        $('#nama_user').text(hasil.nama_pegawai);
        $('#nip').text(hasil.nip);
        $('#id_role').val(hasil.hak_akses);
      }
    });
  }

  function Submit(){
    var id = $('#id_user').val();
    var hak_akses = $('#id_role').val();

    var data = {id:id, hak_akses:hak_akses, }
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url('admin/submitManagementUser'); ?>",
      data:data,
      dataType : 'json',
      success: function(hasil) {
        console.log(hasil);
        if(hasil.status == 'success'){
            localStorage.setItem("sukses",hasil.message)
            window.location.reload();
        }else{
            // localStorage.setItem("error",data.message)
            Swal.fire('Oppss...',hasil.message,'error')
        } 
      }
    });
  }
</script>