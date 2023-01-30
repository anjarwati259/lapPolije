<section class="section">
  <div class="row align-items-top">
    <div class="col-lg-12">
      <div class="card">
        <h5 class="card-title"></h5>
          <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pmn-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" onclick="showData('pmn')"><b>Permintaan Permohonan</b></button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pwn-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" onclick="showData('pwn')"><b>Data Penawaran</b></button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="psn-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false" onclick="showData('psn')"><b>Data Pesanan</b></button>
                </li>
              </ul>

              <div id="loadcontent"></div>
          </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  var pesanTab = JSON.parse(localStorage.getItem("success"));
    if(pesanTab)
    {
        Swal.fire('Success',pesanTab.message,'success');
        $('#'+pesanTab.tabid+'-tab').click();
        localStorage.removeItem('success');
    }

  showData('pmn');
  function showData(id){
    $.ajax({
        url: '<?php echo base_url('admin/loaddata') ?>'+id,
        type: 'POST',
        dataType: "html",
        // data:{
        //     idmenu:idmenu,
        //     keyword: keyword
        // },
        beforeSend: function() {
            // $("#loadloader").show();
            $("#loadcontent").html('');
            $('#pwn-tab').removeClass('active');
            $('#psn-tab').removeClass('active');
            $('#pmn-tab').removeClass('active');
        },
        success: function(data){
          console.log(data);
            $('#'+id+'-tab').addClass('active');
            // $("#loadloader").attr('style', 'display: none;');
            $("#loadcontent").html(data);
        },
        // complete: function(){
        //     $("#loadloader").hide();
        // },
        // error: function (xhr, ajaxOptions, thrownError) {
        //     var pesan = xhr.status + " " + thrownError + "\n" +  xhr.responseText;
        //     $("#loadcontent").html('<div class="alert alert-danger inverse alert-dismissible fade show m-0" role="alert"><i class="icofont icofont-warning-alt"></i> '+pesan+'</div>');
        // },
    });
  }
</script>
<?//php include('permohonan_ajax.php'); ?>