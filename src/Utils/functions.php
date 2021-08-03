<?php
/**
 * @Author: Ali2vu <751815097@qq.com>
 * @Date: 2019-12-20 11:30:18
 * @LastEditors: Ali2vu
 * @LastEditTime: 2020-01-11 18:18:22
 */

declare(strict_types=1);

use Hyperf\Nsq\Nsq;
use Mybank\ConstList\Common;
use Mybank\Constants\ErrorCode;
use Mybank\Exception\BaseException;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\RpcClient\Exception\RequestException;
use Psr\Http\Message\ServerRequestInterface;

if (!function_exists('container')) {
    function container()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('di')) {
    function di($id = null)
    {
        $container = ApplicationContext::getContainer();
        if ($id) {
            return $container->get($id);
        }

        return $container;
    }
}

if (!function_exists('sf')) {
    function sf()
    {
        $generate = ApplicationContext::getContainer()->get(IdGeneratorInterface::class);
        return $generate->generate();
    }
}

/**
 * 缓存实例 简单的缓存
 */
if (!function_exists('cache')) {
    function cache()
    {
        return container()->get(Psr\SimpleCache\CacheInterface::class);
    }
}

/**
 * 发送nsq消息
 */
if(!function_exists('sendNSQ')) {
    function sendNSQ(string $topic, $data, float $deferTime = 0.0)
    {
        try {
            retry(1, function() use ($topic, $data, $deferTime) {
                R("发送NSQ消息${topic}");
                $nsq = di()->get(Nsq::class);
                $nsq->publish($topic, json_encode($data, JSON_UNESCAPED_UNICODE), $deferTime);
                R("发送NSQ消息${topic}->publish");
            });
        } catch (Throwable $e) {
            R($e->getMessage(), "NSQ发送失败");
        }
    }
}

/**
 * 批量发送NSQ消息
 * @author Ali2vu <751815097@qq.com>
 * @param string $topic
 * @param $data
 */
if(!function_exists('sendBatchNSQ')) {
    function sendBatchNSQ(string $topic, $data, $deferTime = 0.0)
    {
        $data = is_string($data) ? [$data] : $data;
        array_map(function($v) use($topic, $deferTime) {
            if (is_array($v)) {
                sendNSQ($topic, $v, $deferTime);
            }
        }, $data);
    }
}

/**
 * 字符串截取
 */
if (!function_exists('gtSubstr')) {
    function gtSubstr($str, $length = 30, $append = true)
    {
        $str = trim($str);
        $strLength = strlen($str);
        if ($length == 0 || $length >= $strLength || $length < 0) {
            return $str;
        }

        if (function_exists('mb_substr')) {
            $newstr = mb_substr($str, 0, $length, 'utf-8');
        } else if (function_exists('iconv_substr')) {
            $newstr = iconv_substr($str, 0, $length, 'utf-8');
        } else {
            $newstr = substr($str, 0, $length);
        }

        if ($append && $str != $newstr){
            $newstr .= '...';
        }
        return $newstr;
    }
}

/**
 * 获取IP
 */
if (!function_exists('getip')) {
    function getip()
    {
        $request = di()->get(RequestInterface::class);
        if ($realip = $request->header('remoteip')) {
            return $realip;
        }

        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
            } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['REMOTE_ADDR'])) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = '0.0.0.0';
            }
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }

        preg_match('/[\\d\\.]{7,15}/', $realip, $onlineip);
        $realip = (!empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0');
        return $realip;
    }
}

/**
 * 批量检查参数在另一个数组是否合法
 */
if (!function_exists('CheckArrIntersect')) {
    function CheckArrIntersect($params, array $mod = [], $message = "缺少请求参数")
    {
        if (empty($params)) {
            throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message);
        }

        foreach ($mod as $key => $value) {
            $tmp = $params[$value] ?? 0;
            if (!$tmp) {
                throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message . ': ' . $value);
            }
        }
    }
}

/**
 * 批量检查参数是否合法
 */
if (!function_exists('CheckArrEmpty')) {
    function CheckArrEmpty($params, $message = "请求参数不能为空")
    {
        if (empty($params)) {
            throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message);
        }

        foreach ($params as $key => $value) {
            if (!$value) {
                throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message . ': ' . $value);
            }
        }
    }
}

/**
 * 批量检查参数是否合法
 */
if (!function_exists('CheckArrInside')) {
    function CheckArrInside($params, $mod, $message = "请求参数不能为空")
    {
        if (empty($params)) {
            throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message);
        }

        if (empty($mod)) {
            throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message);
        }

        if (!in_array($mod, $params)) {
            throw new BaseException(ErrorCode::ERROR_REQUEST_CODE, $message);
        }
    }
}

/**
 * 批量检查参数是否合法
 */
if (!function_exists('ToArray')) {
    function ToArray($data)
    {
        if (!$data) return [];
        if (is_object($data)) {
            return $data->toArray();
        }
    }
}


if (!function_exists('SprintfArray')) {
    function SprintfArray($string, $array)
    {
        $keys    = array_keys($array);
        $keysmap = array_flip($keys);
        $values  = array_values($array);
        while (preg_match('/%\(([a-zA-Z0-9_ -]+)\)/', $string, $m))
        {
            if (!isset($keysmap[$m[1]]))
            {
                return false;
            }
            $string = str_replace($m[0], '%' . ($keysmap[$m[1]] + 1) . '$', $string);
        }

        array_unshift($values, $string);
        return call_user_func_array('sprintf', $values);
    }
}

if (!function_exists('RsaGraceful')) {
    function RsaGraceful($string, $type = 'public')
    {
        $key   = wordwrap($string, 64, PHP_EOL, true);
        $start = '';
        $end   = '';
        switch ($type) {
            case Common::PUBLIC_TYPE:
                $start = '-----BEGIN PUBLIC KEY-----' . PHP_EOL;
                $end   = PHP_EOL . '-----END PUBLIC KEY-----' . PHP_EOL;
                break;

            case Common::PRIVATE_TYPE:
                $start = '-----BEGIN PRIVATE KEY-----' . PHP_EOL;
                $end   = PHP_EOL . '-----END PRIVATE KEY-----' . PHP_EOL;
                break;
        }
        return $start . $key . $end;
    }
}

/**
 * 获取数组元素
 * @author Ali2vu <751815097@qq.com>
 * @param array $array
 * @param string $key
 * @return mixed|string
 */
if (!function_exists('S')) {

    function S($info, string $key, string $default = "", string $type = 'string')
    {
        if (is_object($info)) {
            $tmp = $info->$key ?? $default;
        } else {
            $tmp = $info[$key] ?? $default;
        }

        if ($type == 'money') {
            return number_format((float) $tmp, 2, '.', '');
        }

        return $tmp;
    }
}

if (!function_exists('RequestService')) {
    /**
     * RPC服务调用
     * @author Ali2vu <751815097@qq.com>
     * @param $name
     * @param string $method
     * @param array $data
     * @return mixed
     */
    function RequestService($name, $method = '', $data = [])
    {
        try {
            $consumers    = config('services.consumers');
            $servicesList = array_column($consumers, 'name');
            if (!in_array($name, $servicesList)) {
                throw new BaseException(ErrorCode::ERR_RPC_SERVICE, '服务不存在');
            }

            $client = di()->get(sprintf('App\JsonRpc\%sInterface', $name));
            $result = $client->$method(...$data);
            return $result;
        } catch (RequestException $e) {
            R($e->getMessage(), 'RPC ERR');
            throw new BaseException(ErrorCode::ERR_RPC_SERVICE, $e->getMessage());
        } catch (\Throwable $e) {
            R($e->getMessage(), '小姐姐很忙，请稍等');
            throw new BaseException(ErrorCode::ERR_RPC_SERVICE, '小姐姐很忙，请稍等');
        }
    }
}

/**
 * 替换php变量
 */
if (!function_exists('ReplaceVariable')) {
    function ReplaceVariable(string $html, array $params){
        $pattern = '/\{{([\w]+)\}}/';
        //捕获所有的模板变量
        preg_match_all($pattern, $html,$matches);
        //变量替换
        for($i=0; $i< count($matches[1]); $i++){
            if(isset($params[$matches[1][$i]])){
                $html = preg_replace('/\{\{'.$matches[1][$i].'\}\}/',$params[$matches[1][$i]],$html);
            }
        }
        return $html;
    }
}

/**
 * 获取毫秒级时间戳
 */
if (!function_exists('MicTime')) {
    function micTime() {
        [$micro, $sec] = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($micro) + floatval($sec)) * 1000);
    }
}

if (!function_exists('DownloadPdf')) {
    function DownloadPdf($host, $path, $saveFile){
        go(function () use ($host, $path, $saveFile){
            try {
                $client = new \Swoole\Coroutine\Http\Client($host, 443, true);
                $client->set(['timeout' => -1]);
                $client->setHeaders([
                    'Host' => $host,
                ]);
                $client->download($path, $saveFile);
                R($client->getStatusCode(), '下载状态');
                if (file_exists($saveFile)) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                R($e->getMessage(), '生成pdf文件失败');
                return false;
            }
        });
    }
}

if (!function_exists('getDateRange'))
{
    function getDateRange(int $startTime, int $endTime, string $format = 'Ymd')
    {
        // 计算日期段内有多少天
        $days = ($endTime - $startTime) / 86400;
        // 保存每天日期
        $dates = array();
        for ($i = 0; $i < $days; $i++) {
            $dates[] = date($format, $startTime + (86400 * $i));
        }
        return $dates;
    }
}

/**
 * 过滤数据
 * @author Ali2vu <751815097@qq.com>
 * @param $data
 * @return mixed
 */
if (!function_exists('FilterData')) {

    function FilterData($data, callable $function)
    {
        $data = is_object($data) ? (array) $data : $data;
        if (!$data) return [];
        $first = $data[0] ?? '';
        $isFirst = $first ? false : true;
        $data = $isFirst ? [$data] : $data;
        foreach ($data as $k => &$v) {
            $v = (array) $v;
            $v = $function($v);
        }

        return $isFirst ? reset($data) : $data;
    }
}

/**
 * 自动生成订单号
 */
if (!function_exists('makeOrderId')) {
    function makeOrderId($prefix = 'KHL')
    {
        R($prefix);
        return $prefix . sf();
    }
}

/**
 * 下载文件
 * @author Ali2vu <751815097@qq.com>
 * @param array $array
 * @param string $key
 * @return mixed|string
 */
if (!function_exists('Dlfile')) {

    function Dlfile($file_url, $save_to)
    {
        $in = fopen($file_url, "rb");
        $out = fopen($save_to, "wb");
        while($chunk = fread($in,8192))
        {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }
}

/**
 * 产生随机数串
 * @param integer $len 随机数字长度
 * @return string
 */
if (!function_exists('RandNumers')) {
    function RandNumers($length)
    {
        $key='';
        $pattern='1234567890';
        for($i=0;$i<$length;++$i) {
            $key .= $pattern[mt_rand(0,9)];    // 生成php随机数
        }
        return $key;
    }
}

/**
 * 请求
 */
if (!function_exists('reqAttr')) {
    function reqAttr($name)
    {
        return di()->get(ServerRequestInterface::class)->getAttribute($name);
    }
}

/**
 * 格式化字段
 */
if (!function_exists('TrimString')){
    function TrimString($str)
    {
        if (isset($str)) {
            if (!is_string($str)) {
                $str = (string)$str;
            }
            $str = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", " ", strip_tags($str));
            $str = trim($str);
        }
        return $str;

    }
}

if (!function_exists('CheckUrl')){
    /**
     * 检测图片
     * @param  $url
     * @return bool
     */
    function CheckUrl($url)
    {
        $pattern ="/^(http|https):\/\/.*$/i";
        if(preg_match($pattern, $url)){
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('subBank')){
    /**
     * @author wyf <815108680@qq.com>
     * @param string $str 欲截取的字符串
     * @return string
     */
    function subBank(string $str) {
        $start= substr($str, 0,4);
        $end = substr($str, -4);
        return $start . '****' . $end;
    }
}

/**
 * 获取数组元素
 * @author Ali2vu <751815097@qq.com>
 * @param array $array
 * @param string $key
 * @return mixed|string
 */
if (!function_exists('S')) {

    function S($info, string $key, string $default = "", string $type = 'string')
    {
        if (is_object($info)) {
            $tmp = $info->$key ?? $default;
        } else {
            $tmp = $info[$key] ?? $default;
        }

        if ($type == 'money') {
            return number_format((float) $tmp, 2, '.', '');
        }

        return $tmp;
    }
}

