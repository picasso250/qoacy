<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

/* $_GET, $_POST, $_REQUEST helpers or shortens */

function i(&$param, $or='') {
    return isset($param)? $param : $or;
}

function _req($name, $default = '') 
{
    return isset($_REQUEST[$name]) && $_REQUEST[$name] ? trim($_REQUEST[$name]) : $default;
}

function _post($name)
{
    return isset($_POST[$name]) && $_POST[$name] ? trim($_POST[$name]) : $default;
}

function _get($name)
{
    return isset($_POST[$name]) && $_POST[$name] ? trim($_POST[$name]) : $default;
}

/* html node */

function js_node($src='', $code='') {
    $src_str = $src? ' src="' . ROOT . 'static/js/'.$src.'.js?v='. JS_VER .'"' : '';
    return '<script type="text/javascript"'.$src_str.'>'.$code.'</script>';
}

function css_node($src='', $type='css') {
    $rel = 'rel="stylesheet'.($type!='css'?'/'.$type:'').'"';
    $href = 'href="'.ROOT.'static/css/'.$src.'.'.$type.'?v='. CSS_VER .'"';
    $type = 'type="text/css"';
    return "<link $rel $type $href />";
}

function js_var($var_name, $arr) {
    return js_node('', $var_name.'='.json_encode($arr));
}

function _css($file) {
    return ROOT . "view/css/$file.css";
}

function _js($file) {
    return ROOT . "view/js/$file.js";
}

/* debug helpers */

// little function to help us print_r() or var_dump() things
function d($var, $var_dump=0) {
    if (!(defined('DEBUG') ? DEBUG : 1)) 
        return;

    $is_cli = (PHP_SAPI === 'cli');                              // is cli mode
    $is_ajax = isset($GLOBALS['is_ajax']) && $GLOBALS['is_ajax']; // compitible for low version
    $by_ajax = isset($GLOBALS['by_ajax']) && $GLOBALS['by_ajax']; // ajax
    $html_mode = !($is_cli || $is_ajax || $by_ajax);            // will display in html?

    if ($html_mode) 
        echo '<p><pre>';
    echo PHP_EOL;
    if ($var_dump) {
        var_dump($var);
    } elseif (is_array($var) || is_object($var)) {
        print_r($var);
    } else {
        var_dump($var);
    }
    if ($html_mode) 
        echo '</pre></p>';
    echo PHP_EOL;
}

/* image upload helpers */

/**
 * what is this?
 * @param type $file_content
 * @param type $crop
 * @param type $width
 * @param type $height
 * @param type $new_width
 * @param type $new_height
 * @return type
 * @throws Exception
 */
function image_resize ($file_content, $crop, $width, $height, $new_width, $new_height) {
    if ($new_width < 1 || $new_height < 1) {
        throw new Exception('specified size too small');
    } else if ($width<$new_width || $height<$new_height) {
        throw new Exception('image size too small', 42);
    } else {
        $dst = imagecreatetruecolor($new_width, $new_height);
        $src_x = 0;
        $src_y = 0;
        if ($crop) {
            $ratio = $width / $height;
            $new_ratio = $new_width / $new_height;
            if ($ratio > $new_ratio) {
                $old_width = $width;
                $width = ceil($new_ratio * $height);
                $src_x = ($old_width - $width) / 2;
            } else if ($ratio < $new_ratio) {
                $old_height = $height;
                $height = ceil($width / $new_ratio);
                $src_y = ($old_height - $height) / 2;
            }
        }
        $s = imagecopyresampled($dst, $file_content, 0, 0, $src_x, $src_y, $new_width, $new_height, $width, $height);
        return $dst;
    }
}

function image_file_resize($tmp_img_file, $image_type, $crop, $new_width, $new_height) {
    list($width, $height) = getimagesize($tmp_img_file);
    $image_type_map = array(
        'jpg' => 'jpeg',
        'jpeg' => 'jpeg',
        'pjpeg' => 'jpeg',
        'png' => 'png',
        'x-png' => 'png');
    $image_type = strtolower($image_type);
    if (isset($image_type_map[$image_type]))
        $image_type = $image_type_map[$image_type];
    $src = call_user_func('imagecreatefrom' . $image_type, $tmp_img_file);
    try {
        $dst = image_resize($src, $crop, $width, $height, $new_width, $new_height);
    } catch (Exception $e) {
        throw $e;
    }

    ob_start();
    call_user_func('image' . $image_type, $dst);
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}

// from file
function make_image2($imagefile, $opt = array())
{
    // deault option
    $opt = array_merge(array(
        'crop' => 0,
        'resize' => 0,
        'width' => 50,
        'height' => 50,
        'list' => null,
    ), $opt);
    
    $extention = $image_type = end(explode('.', $imagefile));

    $tmp_img = $imagefile;
    
    return _make_image($tmp_img, $image_type, $extention, $opt);
}

function _make_image($tmp_img, $image_type, $extention, $opt)
{
    $resize = $opt['resize'];
    $opt_list = $opt['list'];
    if (!$opt_list) {
        $opt_list = array($opt);
    }

    $ret = array();
    foreach ($opt_list as $opt_) {
        if ($resize) {
            $content = image_file_resize($tmp_img, $image_type, $opt_['crop'], $opt_['width'], $opt_['height']);
        } else {
            $content = file_get_contents($tmp_img);
        }
        $file_name = uniqid() . '.' . $extention;
        $ret[] = write_upload($content, $file_name);
    }
    return count($ret) === 1 ? reset($ret) : $ret;
}

/**
 * main function
 * @param type $image like $_FILE['xx']
 * @param type $opt resize crop width height
 * @return string url of the final img
 * @throws Exception
 */
function make_image($image, $opt=array()) {
    
    // deault option
    $opt = array_merge(array(
        'crop' => 0,
        'resize' => 0,
        'width' => 50,
        'height' => 50,
        'list' => null,
    ), $opt);
    
    $arr = explode('/', $image['type']);
    $file_type = reset($arr);
    $image_type = end($arr);
    if ($file_type == 'image') {
        
        $extention = file_ext($image['name']);
        
        $tmp_img = $image['tmp_name'];

        return _make_image($tmp_img, $file_type, $extention, $opt);
    } else { // maybe throw??
        return '';
    }
}

// write file content to dst
function write_upload($content, $file_name) {
    if (ON_SAE) {
        $up_domain = UP_DOMAIN;
        $s = new SaeStorage();
        $s->write($up_domain , $file_name , $content);
        return $s->getUrl($up_domain ,$file_name);
    } else {
        $root = 'data/';
        if (!file_exists($root)) {
            mkdir($root);
        }
        $dst_root = $root .'upload/';
        if (!file_exists($dst_root)) {
            mkdir($dst_root);
        }
        $year_month_folder = date('Ym');
        $path = $year_month_folder;
        if (!file_exists($dst_root.$path)) {
            mkdir($dst_root.$path);
        }
        $date_folder = date('d');
        $path .= '/'.$date_folder;
        if (!file_exists($dst_root.$path)) {
            mkdir($dst_root.$path);
        }
        $path .= '/'.$file_name;
        file_put_contents($dst_root.$path, $content);
        return ROOT . 'data/upload/' . $path;
    }
}

function file_ext($file_name) {
    $arr = explode('.', $file_name);
    if (count($arr) < 2) {
        throw new Exception('bad file name: ' . $image['name']);
    }
    return end($arr);
}

// (CamelCase or camelCase) to under_score
// support only one Upper Case
// this function is very important, move it to core!
function camel2under($str)
{
    if (preg_match('/.+[A-Z].+/', $str)) {
        $str = preg_replace('/^(.+)([A-Z].+)$/', '$1_$2', $str); // with underscore
    }
    return strtolower($str);
}


// usage: 
//     $url could be empty, which will go to index, 
//     could be out link, such "http://google.com"
//     also could be absulote path, such as "/root/login"
//     the begining "/" could be omitted
function redirect($url='') {
    // 1. out link ==> directly
    // 2. inner link (without root) ==> add ROOT first
    // 3. inner link (with root) ==> directly
    if (strpos($url, 'http') !== 0 && strpos($url, '/') !== 0) { // inner link relatively
        $url = ROOT . $url;
    }
    header('Location:'.$url);
    exit();
}

function sae_log($msg){
    sae_set_display_errors(false); //关闭信息输出
    sae_debug($msg); //记录日志
    sae_set_display_errors(true); //记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
}

function build_nav($str)
{
    $str = trim($str);
    $arr = array();
    $lines = explode(PHP_EOL, $str); // 问题来了
    $top_key = '';
    foreach ($lines as $line) {
        if (empty($line)) 
            continue;
        if (strpos($line, ' ') === 0) { // sub，甚至，我们可以检查两个空格？
            if (empty($top_key)) {
                throw new Exception('no top key, that means you did not put a top level first, please remove the leading spaces');
            }
            $line = trim($line);

            $arr_ = explode(' ', $line);
            array_shift($arr_); // remove leading char
            $count = count($arr_);
            if ($count < 1)
                throw new Exception("line: $line, must with leading + or -");
            if ($count < 2) {
                $arr_[] = '';
            }
            list($name, $link) = $arr_;

            if (!isset($top_key['sub'])) {
                $top_key['sub'] = array();
            }
            $arr[$top_key]['sub'][] = array(
                'name' => $name,
                'link' => $link);

            // default
            $default = strpos($line, '+') === 0;
            if ($default) {
                $arr[$top_key]['default'] = $link;
            }
        } else { // top
            list($title, $name) = explode(' ', $line);
            $top_key = trim($name);
            if (empty($name)) {
                throw new Exception('you must provide a name');
            }
            $arr[trim($name)] = array('title' => trim($title));
        }
    }
    return $arr;
}

function widget($name, $opts = array()) {
    extract($opts);
    include AppFile::view("widget.$name");
}
