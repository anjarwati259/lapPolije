<script type="text/javascript">
    var pesan = localStorage.getItem("sukses");
    if(pesan)
    {
        Swal.fire('Success',pesan,'success')
        localStorage.removeItem('sukses');
    }

    dataPermohonan();

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

</script>