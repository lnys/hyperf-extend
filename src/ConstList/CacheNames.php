<?php


namespace Mybank\ConstList;


class CacheNames
{
    // JWT缓存
    public const JWT_TOKEN = 'token:%s';

    // APP缓存
    public const APP_TOKEN = 'app:%s';

    // openapi配置
    public const API_CONFIG = 'config:api';

    // 验证码
    public const SMS_CODE = 'sms:%s';

    // 用户对应权限
    public const ROLE_USER_ARR = 'role_user:%s';

    // 任务结算倒计时（5个工作日）
    public const TASK_DISABLE = 'task_disable:%s';

    // 银行网关
    public const BANK_GATEWAY = 'channel:%s';

    // session
    public const SESSION = 'session:%s';

    // 权限&URI
    public const PERMISSIONS = 'permissions:%s';

    // 公司&缓存
    public const TREE_COMPANY = 'system:tree_company';

    // 公告&缓存
    public const LATEST_ANNOUNCEMENT = 'system:announcement';

    // 首页金额缓存
    public const INDEX_RECHARGE = 'index:recharge:%s';
    public const INDEX_RECHARGE_LOG = 'index:recharge_log:%s';
    public const INDEX_WITHDRAW = 'index:withdraw:%s';

    //开票的充值金额
    public const INVOICE_WITHDRAW = 'invoice:withdraw:%s';

    //开票中的金额
    public const INVOICE_PROCESS = 'invoice:process:%s';

    //开票完成的金额
    public const INVOICE_END = 'invoice:end:%s';

    // 单笔下发限制金额
    public const PERSON_LIMIT_MONEY = 'limit:person:money';

    // 公司配置的签章方式
    public const SIGN_COMPANY = 'sign:company:%s';

    // 签章对应的配置信息
    public const SIGN_CONFIG = 'sign:config:%s';

    // e签宝对应的token信息
    public const SIGN_E_TOKEN = 'sign:e:token:%s';

    // 放心签对应的token信息
    public const SIGN_F_TOKEN = 'sign:f:token:%s';

    // 获取服务公司对应的公司
    public const COMPANY_WITH_TENANT_ID = 'company:with:tenantId:%s';

    // 获取服务公司下的员工对应的公司
    public const COMPANY_WITH_USER_ID = 'company:with:userId:%s';
}
