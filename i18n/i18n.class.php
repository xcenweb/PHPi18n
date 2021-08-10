<?php
/**
 * php i18n实现
 * 这里是主类，其实主要作用就是读取i18n文件夹下的php文件组成数组
 * 
 * @author: ITxcen
 * @website: www.xcenadmin.top
 * @E-mail: 1610943675@qq.com|xcenweb@gmail.com
 * @QQ: 1610943675
 * @time: 2021-08-10
 * @Github: github.com/xcenweb/PHPi18n
 *
 */

function L($key){
    //输出对应
	if (func_num_args() == 1) {
        return i18n::get($key);
    }
}

class i18n{

    //确保加载一次
    private static $loaded = false;
    //语言字典数据
	private static $lang   = NULL;
	//语言类型
	public  static $langType = NULL;
	
	public static function get($key){
	    //获取对应语言文件字典
	    self::init();
	    if(!isset(self::$lang[$key])){
			return $key;
		}
		if (func_num_args() == 1) {
	        return self::$lang[$key];
		}
	}
	
	public static function getAll(){
	    //获得字典
		self::init();
		return self::$lang;
	}
	
	public static function getType(){
	    //当前语言内容
		self::init();
		return self::$langType;
	}
	
    public static function lang(){
        //语言判断
        //先获取设置过的或默认的语言并加载
		$lang = str_replace(['/','\\','..','.'],'',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',$lang,$lang,PREG_SET_ORDER);
	    $lang = str_replace("_","-",$lang[0][0]);
	    //默认的语言
	    if(empty($lang)) $lang = 'zh-CN';
	    
	    //获得语种及语类
	    $lang_root = preg_replace('~-.*~','', $lang);
	    $lang_area = str_replace($lang_root . '-','', $lang);
	    
	    //是否为中文(zh
	    if($lang_root == 'zh'){
	        if(in_array($lang_area,'TW','HK','MO','CHS','SG','CHT')){
	            $lang = $lang_root . '-TW';//以上可能都归为繁体中文
	        }else{
	            //其他语言，肯定为zh-CN
	            return $lang;
	        }
	    }else{
	        //其他语言 e.g. en-AS -> en
	        return $lang_root;
	    }
    }
    
    public static function init(){
        //载入
        if(self::$loaded !== false){
            //载入一次了不再加载
			return;
		}
		
		//从cookie获取语言，如果没有就用默认方案
	    $cookieLang = 'i18nUserLanguage';
	    if(isset($_COOKIE[$cookieLang])){
	        $lang = $_COOKIE[$cookieLang];
	    }else{
	        //默认方案
	        $lang = self::lang();
	    }
	    
		$lang = str_replace(['/','\\','..','.'],'',$lang);
        // = =
        $langFile = LANG_PATH.$lang.'/main.php';
		if(!file_exists($langFile)){
			$lang = 'en';
			$langFile = LANG_PATH.$lang.'/main.php';
		}
		
		//表示加载过了
		self::$loaded = true;
		//加载字典
		self::$lang = @include($langFile);
		//指定语言信息
		self::$langType = $GLOBALS['config']['languages'][$lang];
		//print_r(self::$lang);
    }
}
