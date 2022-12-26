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