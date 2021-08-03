<?php
/**
 * @Author: Ali2vu <751815097@qq.com>
 * @Date: 2020-04-01 18:38:51
 * @LastEditors: Ali2vu
 * @LastEditTime: 2020-04-01 18:38:51
 */

declare(strict_types=1);

namespace Mybank\Service\Factory;

class GraylogFactory
{
    public function store($content, $title = "")
    {
        $title = $title ?: $content;
        go ( function () use ($content, $title) {
            $transport = new \Gelf\Transport\UdpTransport(env('GRAYLOG_HOST', '127.0.0.1'), env('GRAYLOG_PORT', 4801), \Gelf\Transport\UdpTransport::CHUNK_SIZE_LAN);
            $publisher = new \Gelf\Publisher();
            $publisher->addTransport($transport);
            $message = new \Gelf\Message();
            $message->setShortMessage($title)
                ->setLevel(\Psr\Log\LogLevel::ALERT)
                ->setFullMessage($content)
                ->setFacility(env('APP_ENV', "dev"));
            $publisher->publish($message);
        });
    }
}