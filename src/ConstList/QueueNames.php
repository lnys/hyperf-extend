<?php


namespace Mybank\ConstList;


class QueueNames
{
    // 异步通知队列
    public const NOTIFY_TOPIC = 'openapi-notify';

    // 批量提现队列
    public const BATCH_WITHDRAW_TOPIC = 'openapi-batch-withdraw';

    // 小程序发起的审核
    public const MINI_BATCH_WITHDRAW_TOPIC = 'miniapp-batch-withdraw';

    // 小程序发送模板消息队列
    public const MINI_SEND_MESSAGE_TOPIC = 'miniapp-send-message';

    // 公司开启短信发送通知队列
    public const NOTIFY_COMPANY_SMS = 'company-sms';

    // 开启银行账户对应的e签宝的组织账户
    public const NOTIFY_ESIGN_ORGANIZATION = 'esign-organization';

    // e签宝pdf文件下载
    public const NOTIFY_ESIGN_DOWNLOAD_PDF = 'esign-download-pdf';
}
