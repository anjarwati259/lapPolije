<script type="text/javascript">
    var pesan = localStorage.getItem("sukses");
    if(pesan)
    {
        Swal.fire('Success',pesan,'success')
        localStorage.removeItem('sukses');
    }

    dataPermohonan();
    dataAnalist();

    function dataPermohonan(){
        var dataTable = $('#daftar_analisis-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('analist/daftarAnalisis'); ?>",  
                type:"POST"  
           },  
           "columnDefs":[  
                {  
                     "targets":[0],
                     "orderable":false,  
                },  
           ],  
        });
    }

    function dataAnalist(){
        var dataTable = $('#Analist-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('analist/getDataAnalist'); ?>",  
                type:"POST"  
           },  
           "columnDefs":[  
                {  
                     "targets":[0],
                     "orderable":false,  
                },  
           ],  
        });
    }

  function SubmitAnalist(){
    var data = new FormData(document.getElementById("form-Analist-data"));
    for (const keyinput of data.keys()){
            let inputAwal = $("#form-Analist-data").find('.is_invalid').remove();
        }
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('analist/addanalist'); ?>",
        data:data,
        dataType : 'json',
        processData: false,
        contentType: false,
        success: function(hasil) {
            console.log(hasil.message);
            if(hasil.status == 'success'){
                localStorage.setItem("sukses",hasil.message)
                window.location.reload();
            }else{
                // localStorage.setItem("error",data.message)
                Swal.fire('Oppss...',hasil.message,'error')
            }

            $.each(hasil.atribute, function (key, value){
                let formCheck = $("#form-jenis_analisa #"+key);

                if(value){
                    formCheck.addClass('is-invalid') 
                }else{
                    formCheck.removeClass('is-invalid')
                }
                formCheck.after("<div class='is_invalid'>"+value+"</div>");
            })
        }
    });
  }

  function editanalist(id){
    document.querySelectorAll("#id_pegawai option").forEach(opt => {
      opt.disabled = true;
    });
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url('analist/getAnalistById'); ?>",
      data:{id:id},
      dataType : 'json',
      success: function(hasil) {
         $.each(hasil, function (key, value){
          let formCheck = $("#"+key);
          formCheck.val(value);
        }) 
      }
    });
  }

  function hapusanalist(id){
        Swal.fire({
            title: '',
            text: 'Apakah Anda Yakin Akan Menghapus Data Ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes',
            allowOutsideClick: false 
        }).then((result, e) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('analist/delAnalist'); ?>", 
                    data:{id:id},
                    dataType : 'json',
                    success: function(hasil) {
                      console.log(hasil)
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
        })
    }
</script>