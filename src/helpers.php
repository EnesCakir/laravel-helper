<?php

// General Helpers
function set_active($path, $active = 'active')
{
    if (is_array($path)) {
        foreach ($path as $p) {
            if (Request::is($p)) {
                return $active;
            }
        }
        return '';
    }
    return Request::is($path)
        ? $active
        : '';
}

function upload_path($folder = null, $file = null)
{
    $path = 'storage';
    if ($folder) {
        $path .= '/' . $folder;
        if ($file) {
            $path .= '/' . $file;
        }
    }
    return $path;
}

function admin_asset($file)
{
    return asset('admin' . '/' . $file);
}

function front_asset($file)
{
    return asset('front' . '/' . $file);
}

function media_path($folder = null, $file = null)
{
    if ($folder == 'admin') {
        return 'resources/admin/media/' . $file;
    } elseif ($folder == 'front') {
        return 'resources/front/images/' . $file;
    }
}

// Session Message Helpers
function session_success($text)
{
    Session::flash('success_message', $text);
}

function session_error($text)
{
    Session::flash('error_message', $text);
}

function session_info($text)
{
    Session::flash('info_message', $text);
}

// API Helpers
function api_success($data = null, $status = 200)
{
    return response()->json([
        'status' => 'success',
        'data'   => $data
    ], $status);
}

function api_error($message, $status = 200)
{
    return response()->json([
        'status'  => 'error',
        'message' => $message
    ], $status);
}

function api_fail($data, $status = 200)
{
    return response()->json([
        'status' => 'fail',
        'data'   => $data
    ], $status);
}

// String Helpers
function remove_turkish($string)
{
    $charsArray = [
        'c' => ['ç', 'Ç'],
        'g' => ['ğ', 'Ğ'],
        'i' => ['I', 'İ', 'ı'],
        'o' => ['Ö', 'ö'],
        's' => ['Ş', 'ş'],
        'u' => ['ü', 'Ü'],
    ];
    foreach ($charsArray as $key => $val) {
        $string = str_replace($val, $key, $string);
    }
    return $string;
}

function title_case_turkish($string)
{
    return mb_convert_case(str_replace('i', 'İ', str_replace('I', 'ı', $string)), MB_CASE_TITLE, 'UTF-8');
}

function upper_case_turkish($string)
{
    return mb_convert_case(str_replace('i', 'İ', str_replace('ı', 'I', $string)), MB_CASE_UPPER, 'UTF-8');
}

function lower_case_turkish($string)
{
    return mb_convert_case(str_replace('İ', 'i', str_replace('I', 'ı', $string)), MB_CASE_LOWER, 'UTF-8');
}

function clean_text($text)
{
    return preg_replace(
        "/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",
        '<$1$2>',
        strip_tags($text, '<p><a><br><pre><i><b><u><ul><li><ol><img><blockquote><h1><h2><h3><h4><h5>')
    );
}

function make_mobile($mobile)
{
    return substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $mobile), -10);
}
