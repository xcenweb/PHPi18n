<?php
/**
 * php i18n实现
 * 
 * @author: ITxcen
 * @website: www.xcenadmin.top
 * @E-mail: 1610943675@qq.com|xcenweb@gmail.com
 * @QQ: 1610943675
 * @time: 2021-08-10
 * @Github: github.com/xcenweb/PHPi18n
 *
 */
define('ROOT_DIR',__DIR__ . '/');//程序目录
define('LANG_PATH',ROOT_DIR . 'i18n/');//i18n语言文件

include ROOT_DIR  . 'set.php'
include LANG_PATH . 'i18n.class.php';

//输出
echo L('hello_world');
?>