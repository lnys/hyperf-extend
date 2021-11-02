<?php
/**
 * @Author: Ali2vu <751815097@qq.com>
 * @Date: 2021-07-20 17:19:13
 * @LastEditors: Ali2vu
 * @LastEditTime: 2021-07-20 17:19:13
 */

declare(strict_types=1);

use Hyperf\Server\Exception\ServerException;
use Hyperf\Utils\ApplicationContext;

if (! function_exists('E')) {
    function E($name = '')
    {
        print_r($name);
        echo PHP_EOL;

        // LOG
        $strName = $name !== "" ? sprintf("\n%s", $name) : "";
        $fullStr = $strName;
        if ($fullStr) {
            ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get("E")->debug($fullStr);
        }
    }
}

if (! function_exists('R')) {
    function R($array, $name = '')
    {
        if ($array === "") return;
        $stdin = true;
        if ($stdin) {
            $content = PHP_EOL.date('Y-m-d H:i:s').PHP_EOL;
            if ($name) {
                $content .= $name . ' -> ';
            }
            $content .= is_array($array) ? json_encode($array) . PHP_EOL : $array . PHP_EOL;
            echo $content;
        }

        // LOG
        if ($array) {
            ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get("R")->debug($content);
        }
    }
}

if (! function_exists('L')) {
    function L($array, $name = '')
    {
        if ($array === "") return;
        $stdin = env('APP_ENV') === "develop";
        if ($stdin) {
            $content = PHP_EOL.date('Y-m-d H:i:s').PHP_EOL;
            if ($name) {
                $content .= $name . ' -> ';
            }
            $content .= is_array($array) ? json_encode($array) . PHP_EOL : $array . PHP_EOL;
            echo $content;
        }

        // LOG
        if ($array) {
            ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get("L")->info($content);
        }
    }
}

if (! function_exists('D')) {
    function D($array, $name = '')
    {
        R($array, $name);
        throw new ServerException(1);
    }
}

if (! function_exists('V')) {
    function V($array, $name = '')
    {
        if ($array === "") {
            return;
        }
        $content = PHP_EOL.date('Y-m-d H:i:s').PHP_EOL;
        if ($name) {
            $content .= $name . PHP_EOL;
        }
        echo $content;
        var_dump($array);
        echo PHP_EOL;
    }
}