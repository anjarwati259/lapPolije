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
			$menu['mainMenu'][$key]['id'] = $value->id;
			$menu['mainMenu'][$key]['url'] = $value->url;
			$menu['mainMenu'][$key]['idParent'] = $value->id;
			$menu['mainMenu'][$key]['isParent'] = $value->is_parent;
			$menu['mainMenu'][$key]['icon'] = $value->icon;
		}else{
			$menu['subMenu'][$key]['menu'] = $value->menu;
			$menu['subMenu'][$key]['id'] = $value->id;
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
	$tempNomor = $CI->permohonan_model->getTempNomor('permohonan');
	$id = (int) $CI->permohonan_model->getIdPermohonan();
	$suffle = (strlen($id) >= 4) ? (0) : (4-strlen($id));
	$randID = $id.substr(str_shuffle('123456789'),1,$suffle);
	$findWord = ['{nomor}', '{tahun}'];
	$replace = [$randID, date('Y')];
	$no_permohonan = str_replace($findWord, $replace, $tempNomor->temp_nomor);
	
	return $no_permohonan;
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

function generateNomorSample($no_permohonan, $no_sample){
	$kode = substr($no_permohonan,0,4);
	$result = $kode.'-'.$no_sample;
	return $result;
}

function generateKodeSample($jenis, $id, $no_permohonan=null){
	$CI = get_instance();
	// $CI->load->model('user_model');
	$tempNomor = $CI->permohonan_model->getTempNomor($jenis);
	$kode = substr($no_permohonan,0,4);
	$findWord = ['{kode_registrasi}', '{nomor}'];
	$replace = [$kode, $id];
	$kode = str_replace($findWord, $replace, $tempNomor->temp_nomor);
	
	return $kode;
}

function getNoBlanko($id_permohonan, $no_sample){
	$CI = get_instance();
	$detailSample = $CI->permohonan_model->detailSample($id_permohonan, $no_sample);
	return $detailSample->no_blanko;
}

function terbilang($x) {
  $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

  if ($x < 12)
    return " " . $angka[$x];
  elseif ($x < 20)
    return terbilang($x - 10) . " belas";
  elseif ($x < 100)
    return terbilang($x / 10) . " puluh" . terbilang($x % 10);
  elseif ($x < 200)
    return "seratus" . terbilang($x - 100);
  elseif ($x < 1000)
    return terbilang($x / 100) . " ratus" . terbilang($x % 100);
  elseif ($x < 2000)
    return "seribu" . terbilang($x - 1000);
  elseif ($x < 1000000)
    return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}


// function hitungTotalHarga($no_permohonan){
// 	$tempNomor = $CI->permohonan_model->getTotal($no_permohonan);
// }