<script type="text/javascript">
    var pesan = localStorage.getItem("sukses");
    if(pesan)
    {
        Swal.fire('Success',pesan,'success')
        localStorage.removeItem('sukses');
    }

    dataUnit();

    function dataUnit(){
        var dataTable = $('#unit-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('unit/getDataUnit'); ?>",  
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

    function SubmitUnit(){
        var data = new FormData(document.getElementById("form-unit"));
        for (const keyinput of data.keys()){
            let inputAwal = $("#form-unit").find('.is_invalid').remove();
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('unit/addUnit'); ?>",
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
                    let formCheck = $("#form-unit #"+key);

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

    function editunit(id){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('unit/getUnit'); ?>",
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

    function hapusunit(id){
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
                    url: "<?php echo base_url('unit/delUnit'); ?>", data:{id:id},
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