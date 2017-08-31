<?php
/**
 * Created by PhpStorm.
 * User: zheyin.liang
 * Date: 2017/8/31
 * Time: 下午4:19
 */

function valid_params_checklist($to_check_list, $arr) {
    foreach ($to_check_list as $key => $value) {
        if (!isset($arr[$key])) {
            throw new Exception("$key is empty", self::PARAM_ERROR_CODE);
        }
        if (is_array($value)) {
            if (!in_array($arr[$key], $value)) {
                throw new Exception("$key can only be " . implode(' / ', $value), self::PARAM_ERROR_CODE);
            }
            continue;
        }
        if (is_callable($value) && !is_string($value)) {
            if (!$value($arr[$key])) {
                throw new Exception("$key format error", self::PARAM_ERROR_CODE);
            }
            continue;
        }
        if (is_string($value)) {
            $check_function = 'is_' . $value;
            if (!$check_function($arr[$key])) {
                throw new Exception("$key is not " . $value, self::PARAM_ERROR_CODE);
            }
        }
    }
}