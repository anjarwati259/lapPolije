<script type="text/javascript">
    var pesan = localStorage.getItem("sukses");
    if(pesan)
    {
        Swal.fire('Success',pesan,'success')
        localStorage.removeItem('sukses');
    }

    dataJabatan();

    function dataJabatan(){
        var dataTable = $('#jabatan-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('jabatan/getDataJabatan'); ?>",  
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

    function SubmitJabatan(){
        var data = new FormData(document.getElementById("form-jabatan"));
        for (const keyinput of data.keys()){
            let inputAwal = $("#form-jabatan").find('.is_invalid').remove();
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('jabatan/addJabatan'); ?>",
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
                    let formCheck = $("#form-jabatan #"+key);

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

    function editjabatan(id){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('jabatan/getJabatan'); ?>",
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

    function hapusjabatan(id){
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
                    url: "<?php echo base_url('jabatan/delJabatan'); ?>",
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