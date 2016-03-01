<?php
//获取和设置配置参数
function C($_name=null, $_value=null,$_default=null) {
	//存放参数静态变量数组
	static $_config=array();
	// 无参数时获取所有
	if (empty($_name)) {
		return $_config;
	}
	// 优先执行设置获取或赋值
	if (is_string($_name)) {
		if (!strpos($_name, '.')) {
			$_name = strtolower($_name);
			if (is_null($_value))
				return isset($_config[$_name]) ? $_config[$_name] : $_default;
				$_config[$_name] = $_value;
				return;
		}
		// 二维数组设置和获取支持
		$_name = explode('.', $_name);
		$_name[0]   =  strtolower($_name[0]);
		if (is_null($_value))
			return isset($_config[$_name[0]][$_name[1]]) ? $_config[$_name[0]][$_name[1]] : $_default;
			$_config[$_name[0]][$_name[1]] = $_value;
			return;
	}
	// 批量设置
	if (is_array($_name)){
		$_config = array_merge($_config, array_change_key_case($_name));
		return;
	}
	return null; // 避免非法参数
	
}

//实列化数据模型
function M($_table){
	static $_model  = array();
	$_name=md5($_table);
	//数据模型已存在 直接返回
	if(isset($_model[$_name])) return $_model[$_name];
	$_table=ucfirst(strtolower($_table));
	if(Storage::has(APP_MODEL.$_table.'Model'.EXT)){
		$_modelName=$_table.'Model';
		$_model[$_name]= new $_modelName(strtolower($_table));
	}elseif (Storage::has(APP_MODEL.'CommonModel'.EXT)){
		//存在公共模型
		$_model[$_name]= new CommonModel(strtolower($_table));
	}else{
		//原模型
		$_model[$_name]= new Model(strtolower($_table));
	}
	return $_model[$_name];
}

//抛出异常处理
function E($_msg, $_code=0) {
	throw new MyError($_msg, $_code);
}

//快速导入第三方类库
function V($_filename,$_index=null){
	$_filename=ucfirst(strtolower($_filename));
	if(is_null($_index)){
		$_vfile=VENDOR_PATH.$_filename.'/Index.php';
	}else{
		$_vfile=VENDOR_PATH.$_filename.$_index;
	}
	require_cache($_vfile);
}

// 优化的require_once
function require_cache($_filename) {
	static $_importFiles = array();
	$_md5Files=md5($_filename);
	if (!isset($_importFiles[$_md5Files])) {
		if (file_exists($_filename)) {
			require $_filename;
			$_importFiles[$_md5Files] = true;
		} else {
			$_importFiles[$_md5Files] = false;
		}
	}
	return $_importFiles[$_md5Files];
}

//编绎PHP文件
function compile($_fileName) {
	$_content    =   php_strip_whitespace($_fileName);//删除 PHP 注释以及空白字符
	$_content    =   trim(substr($_content,5));
	if ('?>' == substr($_content, -2))
		$_content    = substr($_content, 0, -2);
		return $_content;
}

//session管理函数
function session($name,$value='') {
	$prefix   =  C('SESSION_PREFIX');
	if(is_array($name)) { // session初始化 在session_start 之前调用
		if(isset($name['prefix'])) C('SESSION_PREFIX',$name['prefix']);
		if(C('VAR_SESSION_ID') && isset($_REQUEST[C('VAR_SESSION_ID')])){
			session_id($_REQUEST[C('VAR_SESSION_ID')]);
		}elseif(isset($name['id'])) {
			session_id($name['id']);
		}

		if(isset($name['name']))            session_name($name['name']);
		if(isset($name['path']))            session_save_path($name['path']);
		if(isset($name['domain']))          ini_set('session.cookie_domain', $name['domain']);
		if(isset($name['expire']))          ini_set('session.gc_maxlifetime', $name['expire']);
		if(isset($name['use_trans_sid']))   ini_set('session.use_trans_sid', $name['use_trans_sid']?1:0);
		if(isset($name['use_cookies']))     ini_set('session.use_cookies', $name['use_cookies']?1:0);
		if(isset($name['cache_limiter']))   session_cache_limiter($name['cache_limiter']);
		if(isset($name['cache_expire']))    session_cache_expire($name['cache_expire']);
		if(isset($name['type']))            C('SESSION_TYPE',$name['type']);

		// 启动session
		if(C('SESSION_AUTO_START'))  session_start();
	}elseif('' === $value){
		if(0===strpos($name,'[')) { // session 操作
			if('[pause]'==$name){ // 暂停session
				session_write_close();
			}elseif('[start]'==$name){ // 启动session
				session_start();
			}elseif('[destroy]'==$name){ // 销毁session
				$_SESSION =  array();
				session_unset();
				session_destroy();
			}elseif('[regenerate]'==$name){ // 重新生成id
				session_regenerate_id();
			}
		}elseif(0===strpos($name,'?')){ // 检查session
			$name   =  substr($name,1);
			if(strpos($name,'.')){ // 支持数组
				list($name1,$name2) =   explode('.',$name);
				return $prefix?isset($_SESSION[$prefix][$name1][$name2]):isset($_SESSION[$name1][$name2]);
			}else{
				return $prefix?isset($_SESSION[$prefix][$name]):isset($_SESSION[$name]);
			}
		}elseif(is_null($name)){ // 清空session
			if($prefix) {
				unset($_SESSION[$prefix]);
			}else{
				$_SESSION = array();
			}
		}elseif($prefix){ // 获取session
			if(strpos($name,'.')){
				list($name1,$name2) =   explode('.',$name);
				return isset($_SESSION[$prefix][$name1][$name2])?$_SESSION[$prefix][$name1][$name2]:null;
			}else{
				return isset($_SESSION[$prefix][$name])?$_SESSION[$prefix][$name]:null;
			}
		}else{
			if(strpos($name,'.')){
				list($name1,$name2) =   explode('.',$name);
				return isset($_SESSION[$name1][$name2])?$_SESSION[$name1][$name2]:null;
			}else{
				return isset($_SESSION[$name])?$_SESSION[$name]:null;
			}
		}
	}elseif(is_null($value)){ // 删除session
		if($prefix){
			unset($_SESSION[$prefix][$name]);
		}else{
			unset($_SESSION[$name]);
		}
	}else{ // 设置session
		if($prefix){
			if (!isset($_SESSION[$prefix])) {
				$_SESSION[$prefix] = array();
			}
			$_SESSION[$prefix][$name]   =  $value;
		}else{
			$_SESSION[$name]  =  $value;
		}
	}
}

//Cookie 设置、获取、删除
function cookie($name, $value='', $option=null) {
	// 默认设置
	$config = array(
			'prefix'    =>  C('COOKIE_PREFIX'), // cookie 名称前缀
			'expire'    =>  C('COOKIE_EXPIRE'), // cookie 保存时间
			'path'      =>  C('COOKIE_PATH'), // cookie 保存路径
			'domain'    =>  C('COOKIE_DOMAIN'), // cookie 有效域名
	);
	// 参数设置(会覆盖黙认设置)
	if (!is_null($option)) {
		if (is_numeric($option))
			$option = array('expire' => $option);
			elseif (is_string($option))
			parse_str($option, $option);
			$config     = array_merge($config, array_change_key_case($option));
	}
	// 清除指定前缀的所有cookie
	if (is_null($name)) {
		if (empty($_COOKIE))
			return;
			// 要删除的cookie前缀，不指定则删除config设置的指定前缀
			$prefix = empty($value) ? $config['prefix'] : $value;
			if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
				foreach ($_COOKIE as $key => $val) {
					if (0 === stripos($key, $prefix)) {
						setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
						unset($_COOKIE[$key]);
					}
				}
			}
			return;
	}
	$name = $config['prefix'] . $name;
	if ('' === $value) {
		if(isset($_COOKIE[$name])){
			$value =    $_COOKIE[$name];
			if(0===strpos($value,'think:')){
				$value  =   substr($value,6);
				return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
			}else{
				return $value;
			}
		}else{
			return null;
		}
	} else {
		if (is_null($value)) {
			setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
			unset($_COOKIE[$name]); // 删除指定cookie
		} else {
			// 设置cookie
			if(is_array($value)){
				$value  = json_encode(array_map('urlencode',$value));
			}
			$expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
			setcookie($name, $value, $expire, $config['path'], $config['domain']);
			$_COOKIE[$name] = $value;
		}
	}


}


///数据XML编码
function data_to_xml($_data, $_item='item', $_id='id') {
	$_xml = $_attr = '';
	foreach ($_data as $_key => $_val) {
		if(is_numeric($_key)){
			$_id && $_attr = " {$_id}=\"{$_key}\"";
			$_key  = $_item;
		}
		
		$_xml    .=  "<{$_key}{$_attr}>";
		$_xml    .=  (is_array($_val) || is_object($_val)) ? data_to_xml($_val, $_item, $_id) : $_val;
		$_xml    .=  "</{$_key}>";
	}
	return $_xml;
}
//页码过滤
function checkPage($_page){
	return is_numeric($_page)?$_page:1;
}
//检测是否最新
function checknew($time) {
	static $_time=null;
	if(is_null($_time)){$_time=time()-(24 * 60 * 60);}
	if($time>$_time){
		return true;
	}else{
		return false;
	}
}
//对象转数组
function objectToArray($_object){
	foreach ($_object as $_key=>$_value){
		$_array[$_key]=is_object($_value)?objectToArray($_value):$_value;
	}
	return $_array;
}
