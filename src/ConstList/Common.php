<?php


namespace Mybank\ConstList;


class Common
{
    public const STATUS_TRUE = true;
    public const STATUS_FALSE = false;

    // 状态
    public const STATUS_DEFAULT = 0;       // 待审核
    public const STATUS_PENDING = 1;       // 审核中
    public const STATUS_AUDIT_SUCCESS = 2;      // 审核通过
    public const STATUS_AUDIT_FAILED = 3;       // 拒绝

    // 发放状态
    public const STATUS_00 = '00';
    public const STATUS_01 = '01';
    public const STATUS_02 = '02';
    public const STATUS_11 = '11';

    // 发放状态消息
    public const SEND_WAITING = '待发放';
    public const SEND_SUBMITTED = '银行处理中';
    public const SEND_FAILED = '发放失败';
    public const SEND_OK = '已发放';

    // 充值状态消息
    public const REMIT_WAITING = '已挂账';
    public const REMIT_CANCEL = '已销账';
    public const REMIT_OK = '成功';

    // 数据来源
    public const SOURCE_OPENAPI = 'openapi';
    public const SOURCE_SAAS = 'saas';


    // 身份证
    public const IDENTITY_ICARD = 1;

    // 港澳台通行证
    public const IDENTITY_PERMIT = 2;

    // 护照
    public const IDENTITY_PASSPORT = 3;

    // 支付类型
    public const PAY_ALIPAY = 'ALIPAY';
    public const PAY_BANK = 'OTHERBANK';

    // 时间
    public const TIME_DAY = 60 * 60 * 24;
    public const TIME_THREEDAY = self::TIME_DAY * 3;
    public const TIME_FIVEDAY = self::TIME_DAY * 5;
    public const TIME_WEEKLY = self::TIME_DAY * 7;
    public const TIME_MONTH = self::TIME_DAY * 30;
    public const DATE_YEAR = self::TIME_DAY * 365;

    // 银行类型
    public const BANK_PID_WS = 'ws';        // 网商银行
    public const BANK_PID_SJ = 'sj';        // 盛京银行
    public const BANK_PID_ALIPAY = 'alipay';        // 支付宝
    public const BANK_PID_YINLING = 'yinling';        // 银灵科技
    public const BANK_PID_PINGAN = 'pingan';        // 平安银行

    // 推送类型
    public const TRADE_WITHDRAW = 'withdrawal_status_sync';     // 单笔提现
    public const TRADE_RECHARGE = 'remit_sync';                 // 子账户汇入
    public const TRADE_TRANSFER = 'transfer_status_sync';       // 转账通知
    public const TRADE_PAY_MSG = 'pay_status_sync';            // 支付通知
    public const TRADE_MESSAGE = 'trade_status_sync';           // 交易通知

    // RSA类型
    public const PUBLIC_TYPE = 'public';
    public const PRIVATE_TYPE = 'private';

    // 银灵子账号类型
    public const SUB_ACCOUNT_COMPANY = '01';    // 用工企业账户
    public const SUB_ACCOUNT_TAXER = '02';      // 服务费账户

    // 银灵成功码
    public const YL_SUCCESS_CODE = 'S00000';
    public const YL_TRADE_SUCCESS = '91';       // 交易成功
    public const YL_TRADE_FAIL = '99';          // 交易失败
}
