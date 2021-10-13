<?php
/**
 * @Author: Ali2vu <751815097@qq.com>
 * @Date: 2021-07-20 17:23:36
 * @LastEditors: Ali2vu
 * @LastEditTime: 2021-07-20 17:23:36
 */

declare(strict_types=1);

use Hyperf\Utils\ApplicationContext;

/**
 * 容器实例
 */
if (!function_exists('Container')) {
    function Container()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('Di')) {
    function Di($id = null)
    {
        $container = ApplicationContext::getContainer();
        if ($id) {
            return $container->get($id);
        }

        return $container;
    }
}

if (!function_exists('IsJson')) {
    function IsJson($string)
    {
        try {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        } catch (\Throwable $e) {
            return false;
        }
    }
}

if (!function_exists('RandId')) {
    function RandId(int $length = 10)
    {
        $rand = rand(5, 15);
        return substr(str_replace("-", '', \Ramsey\Uuid\Uuid::uuid1(Di(\Ramsey\Uuid\Provider\Node\RandomNodeProvider::class)->getNode())), $rand, $length);
    }
}

if (!function_exists('FilterSpace')) {
    function FilterSpace($string)
    {
        return preg_replace('# #', '', $string);
    }
}