<?php

namespace SmartJson\Pay\Gateways\Alipay;

class WapGateway extends WebGateway
{
    /**
     * Get method config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'alipay.trade.wap.pay';
    }

    /**
     * Get productCode config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getProductCode(): string
    {
        return 'QUICK_WAP_WAY';
    }
}
