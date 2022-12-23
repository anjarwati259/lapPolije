<script type="text/javascript">
    var pesan = localStorage.getItem("sukses");
    if(pesan)
    {
        Swal.fire('Success',pesan,'success')
        localStorage.removeItem('sukses');
    }

    dataMetodeanalisa();

    function dataMetodeanalisa(){
        var dataTable = $('#metode_analisa-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('metode_analisa/getDataMetodeanalisa'); ?>",
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

    function SubmitMetodeanalisa(){
        var data = new FormData(document.getElementById("form-metode_analisa"));
        for (const keyinput of data.keys()){
            let inputAwal = $("#form-metode_analisa").find('.is_invalid').remove();
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('metode_analisa/addMetodeanalisa'); ?>",
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
                    let formCheck = $("#form-metode_analisa #"+key);

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

    function editmetode_analisa(id){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('metode_analisa/getMetodeanalisa'); ?>",
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

    function hapusmetode_analisa(id){
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
                    url: "<?php echo base_url('metode_analisa/delMetodeanalisa'); ?>", data:{id:id},
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