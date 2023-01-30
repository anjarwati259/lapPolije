<?php 
function getMenu($role){
	$CI = get_instance();
	$CI->load->model('user_model');
	$dataMenu = $CI->user_model->getMenu($role);
	$menu = array();
	$isSubmenu = false;
	foreach ($dataMenu as $key => $value) {
		if($value->parent == null){
			$menu['mainMenu'][$key]['menu'] = $value->menu;
			$menu['mainMenu'][$key]['url'] = $value->url;
			$menu['mainMenu'][$key]['idParent'] = $value->id;
			$menu['mainMenu'][$key]['isParent'] = $value->is_parent;
			$menu['mainMenu'][$key]['icon'] = $value->icon;
		}else{
			$menu['subMenu'][$key]['menu'] = $value->menu;
			$menu['subMenu'][$key]['url'] = $value->url;
			$menu['subMenu'][$key]['parent'] = $value->parent;
			// $menu['subMenu'][$key]['isParent'] = $value->is_parent;
			$menu['subMenu'][$key]['icon'] = $value->icon;
			$isSubmenu = true;
		}
	}
	if($isSubmenu == false){
		$menu['subMenu'] = null;
	}
	return $menu;
}

function getKodeRegistrasi(){
	$CI = get_instance();
	$CI->load->model('user_model');
	$tempNomor = $CI->permohonan_model->getTempNomor('Registrasi');
	$randID = substr(str_shuffle('123456789'),1,4);
	$findWord = ['{nomor}', '{tahun}'];
	$replace = [$randID, date('Y')];
	$kode_registrasi = str_replace($findWord, $replace, $tempNomor->temp_nomor);
	
	return $kode_registrasi;
}

function dateDefault($date)
{
	$indoBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

	$date    = explode('-', $date);
	$month = (int)$date[1]-1;
	$defaultDate = $date[2] . ' ' . $indoBulan[ $month ] . ' ' . $date[0];
	return $defaultDate;
}

function generateUrl($kode){
	$kode = base64_encode($kode);
    $urlKode = urlencode($kode);
    return $urlKode;
}

function generateKode($jenis, $id){
	$CI = get_instance();
	$CI->load->model('user_model');
	$tempNomor = $CI->permohonan_model->getTempNomor($jenis);
	$findWord = ['{nomor}', '{tahun}'];
	$replace = [$id, date('Y')];
	$kode = str_replace($findWord, $replace, $tempNomor->temp_nomor);
	
	return $kode;
}

function generateSuratTugas(){
	$CI = get_instance();
	// $tempNomor = $CI->permohonan_model->getTempNomor('surat_tugas');
	$last_id = $CI->permohonan_model->lastNoSurat();

	if(!empty($last_id->no_surat)){
		$no_surat = (int) $last_id->no_surat + 1;
		$surat_tugas = generateKode('surat_tugas', $no_surat);
	}else{
		$no_surat = 1;
		$surat_tugas = generateKode('surat_tugas', $no_surat);
	}

	$result = array('no_surat' => $no_surat, 'surat_tugas' => $surat_tugas);
	return $result;
}

function generateNomorSample($kode_registrasi, $no_sample){
	$kode = substr($kode_registrasi,0,4);
	$result = $kode.'-'.$no_sample;
	return $result;
}

// function hitungTotalHarga($kode_registrasi){
// 	$tempNomor = $CI->permohonan_model->getTotal($kode_registrasi);
// }