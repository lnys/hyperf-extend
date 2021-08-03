<?php
/**
 * @Author: Ali2vu <751815097@qq.com>
 * @Date: 2019-12-21 00:26:09
 * @LastEditors: Ali2vu
 * @LastEditTime: 2020-01-06 14:54:07
 */

declare(strict_types=1);

namespace Mybank\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * 自定义业务代码规范如下：
 * 授权相关，1001……
 * 用户相关，2001……
 * 业务相关，3001……
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Internal Server Error!")
     */
    const ERR_SERVER = 500;

    /**
     * @Message("无权限访问！")
     */
    const ERR_NOT_ACCESS = 2001;

    /**
     * @Message("令牌过期！")
     */
    const ERR_EXPIRE_TOKEN = 2002;

    /**
     * @Message("令牌无效！")
     */
    const ERR_INVALID_TOKEN = 2003;

    /**
     * @Message("令牌不存在！")
     */
    const ERR_NOT_EXIST_TOKEN = 2004;

    /**
     * @Message("请登录！")
     */
    const ERR_NOT_LOGIN = 2005;

    /**
     * @Message("用户信息错误！")
     */
    const ERR_USER_INFO = 2006;

    /**
     * @Message("用户不存在！")
     */
    const ERR_USER_ABSENT = 2007;

    /**
     * 用户相关逻辑异常
     * @Message("用户密码不正确！")
     */
    const ERR_EXCEPTION_USER = 2009;

    /**
     * 文件上传
     * @Message("文件上传异常！")
     */
    const ERR_EXCEPTION_UPLOAD = 3000;

    /**
     * @Message("验证码发送失败")
     */
    const ERR_SMS_SEND_FAILED = 3001;

    /**
     * @Message("验证码验证失败")
     */
    const ERR_SMS_VERIFY_FAILED = 3002;

    /**
     * @Message("EXCEL导入错误")
     */
    const ERR_EXCEL_IMPORT_FAILED = 3003;

    /**
     * @Message("数据已经存在，不允许更改")
     */
    const ERR_ONLY_READ = 3005;

    /**
     * @Message("缺少商户id或者服务公司id")
     */
    const ERR_NOT_EXIST_COMPANY = 3006;

    /**
     * @Message("审核出错")
     */
    const ERR_AUDIT = 3007;

    /**
     * @Message("银行出错")
     */
    const ERR_BANK = 3008;

    /**
     * @Message("excel相关错误")
     */
    const ERR_EXCEL = 3009;

    /**
     * @Message("此表格存在未签约的人员，请先进行人才签约")
     */
    const ERR_EXCEL_NOT_SIGN = 3010;

    /**
     * @Message("OSS相关错误")
     */
    const ERR_OSS = 3011;

    /**
     * @Message("签约相关错误")
     */
    const ERR_SIGN = 3012;

    /**
     * @Message("禁止登录，请联系管理员")
     */
    const ERR_NOT_ALLOW_LOGIN = 3013;

    /**
     * @Message("业务逻辑异常！")
     */
    const ERR_EXCEPTION = 3004;

    /**
     * @Message("服务调用失败！")
     */
    const ERR_RPC_SERVICE = 9999;

    /**
     * @Message("业务参数请求错误")
     */
    const ERROR_REQUEST_CODE = 4000;
}
