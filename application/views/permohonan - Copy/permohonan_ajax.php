<script type="text/javascript">
    var pesan = localStorage.getItem("sukses");
    if(pesan)
    {
        Swal.fire('Success',pesan,'success')
        localStorage.removeItem('sukses');
    }
    dataPermohonan();
    riwayatPermohonan();

	let index = 1;
    let totalIndex = 1;
	function setMetode(id){
		var idJenisanalisa = $("#jenis_analisa"+id).val()
		$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/getMetodeanalisa'); ?>",
            data:{id:idJenisanalisa, type:'analisa'},
            dataType : 'html',
            success: function(hasil) {
                $("#metode_analisa"+id).html(hasil);
            }
        });
	}

	function addFrom(){
		index = index+1;
        totalIndex = totalIndex+1;
		$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/getMetodeanalisa'); ?>",
            data:{index:index, type:'add'},
            dataType : 'html',
            success: function(hasil) {
            	var html = '<tr id="tr'+index+'"><th scope="row">'+index+'</th><td>'+hasil+'</td><td><select name="metode_analisa'+index+'" id="metode_analisa'+index+'" class="form-select"></>select></td> <td><button type="button" class="btn btn-danger btn-sm" onclick="delPermohonan('+"\'"+index+"\'"+')"> Hapus</button></td>';
                var input = '<input type="hidden" value="0" name="status'+index+'" id="status'+index+'">';
                $("#addForm").append(html);
                $("#addForm").append(input);
                // console.log(html);
            }
        });
		
	}

    function delPermohonan(id){
        $("#tr"+id).hide();
        $("#status"+id).val('1');
        index = index-1;
    }

    function simpan(action){
        var data = {}
        var row = 0;

        var no_permohonan = $('#no_permohonan').val();
        var tgl_kirim = $('#tgl_kirim').val();
        var jenis_sample = $('#jenis_sample').val();
        var jml_sample = $('#jml_sample').val();
        var penyimpanan = $('#penyimpanan').val();
        var keterangan_sample = $('#keterangan_sample').val();
        var id_customer = $('#id_customer').val();

        data.action = action;
        for (var i = 1; i <= totalIndex; i++) {
            var status = $('#status'+i).val();
            var jenis_analisa = $('#jenis_analisa'+i).val();
            var metode_analisa = $('#metode_analisa'+i).val();
            if(status != 1){
                row+=1;
                data[row] = {['jenis_analisa']: jenis_analisa,
                            ['metode_analisa']: metode_analisa}
            }
        }
        data['0'] = {['totalIndex']:row, 
                     ['no_permohonan']:no_permohonan, 
                     ['id_customer']:id_customer, 
                     ['tgl_kirim']: tgl_kirim,
                     ['jenis_sample']: jenis_sample,
                     ['jml_sample']: jml_sample,
                     ['penyimpanan']: penyimpanan,
                     ['keterangan_sample']: keterangan_sample,
                 }
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/simpanPermohonan'); ?>",
            data:data,
            dataType : 'json',
            success: function(hasil) {
                console.log(hasil)
                var url = "<?php echo base_url('permohonan/riwayatPermohonan'); ?>";
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

    function riwayatPermohonan(){
        var dataTable = $('#riwayat_permohonan-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('permohonan/getDatapermohonan'); ?>",  
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

    function kirimSampel(kode){
        var no_permohonan = atob(kode);
        $('#judul-kode').html('Kode #'+no_permohonan);
        $('#no_permohonan').val(kode);
    }

    function kirimResi(){
        var no_permohonan = $('#no_permohonan').val();
        var tgl_kirim = $('#tgl_kirim').val();
        var no_resi = $('#no_resi').val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/kirimResi'); ?>",
            data:{no_permohonan:no_permohonan, tgl_kirim:tgl_kirim, no_resi:no_resi},
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

    function dataPermohonan(){
        var dataTable = $('#data_permohonan-data').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('permohonan/dataPermohonanAdmin'); ?>",  
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

    function simpanAdmin(){
        var data = {}

        var tgl_terima_sample = $('#tgl_terima_sample').val();
        var tgl_perkiraan_selesai = $('#tgl_perkiraan_selesai').val();
        var kode_sample = $('#kode_sample').val();
        var kode_order = $('#kode_order').val();
        var no_permohonan = $('#no_permohonan').val();

        var totalAnalist = '<?php echo count($dataAnalist) ?>';

        for (var i = 1; i <= totalAnalist; i++) {
            var id = $('#id'+i).val();
            var id_analist = $('#id_analist'+i).val();
            data[i] = {['id']: id,
                        ['id_analist']: id_analist}
        }
        data['0'] = {['no_permohonan']:no_permohonan, 
                     ['tgl_terima_sample']:tgl_terima_sample, 
                     ['tgl_perkiraan_selesai']:tgl_perkiraan_selesai, 
                     ['kode_sample']: kode_sample,
                     ['kode_order']: kode_order,
                 }
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
    function submitAnalist(){
        var id_detail = $('#id_detail').val();
        var ulangan1 = $('#ulangan1').val();
        var ulangan2 = $('#ulangan2').val();
        var rata_rata = $('#rata_rata').val();
        var id_analist = $('#id_analist').val();
        var no_permohonan = $('#no_permohonan').val();

        var data = {id:id_detail,
                    no_permohonan:no_permohonan,
                    ulangan1:ulangan1,
                    ulangan2:ulangan2,
                    id_analist:id_analist,
                    rata_rata: rata_rata };
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('analist/submitAnalisa'); ?>",
            data:data,
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

    function appAnalist(id, no_permohonan){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('analist/ApprovedAnalisa'); ?>",
            data:{id:id, no_permohonan:no_permohonan},
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
</script>