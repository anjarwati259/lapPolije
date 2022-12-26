<script type="text/javascript">
	let index = 1;
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
		$.ajax({
            type: 'POST',
            url: "<?php echo base_url('permohonan/getMetodeanalisa'); ?>",
            data:{index:index, type:'add'},
            dataType : 'html',
            success: function(hasil) {
            	var html = '<tr id="tr'+index+'"><th scope="row">'+index+'</th><td>'+hasil+'</td><td><select name="metode_analisa'+index+'" id="metode_analisa'+index+'" class="form-select"></>select></td> <td><button type="button" class="btn btn-danger btn-sm"> Hapus</button></td>'

                $("#addForm").append(html);
            }
        });
		
	}
</script>