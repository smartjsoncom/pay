<?php

namespace SmartJson\Pay\Gateways\Alipay;

use SmartJson\Pay\Contracts\GatewayInterface;
use SmartJson\Pay\Log;
use SmartJson\Supports\Collection;
use SmartJson\Supports\Config;

class PosGateway implements GatewayInterface
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Bootstrap.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Pay an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['method'] = $this->getMethod();
        $payload['biz_content'] = json_encode(array_merge(
            json_decode($payload['biz_content'], true),
            [
                'product_code' => $this->getProductCode(),
                'scene'        => 'bar_code',
            ]
        ));
        $payload['sign'] = Support::generateSign($payload, $this->config->get('private_key'));

        Log::debug('Paying A Pos Order:', [$endpoint, $payload]);

        return Support::requestApi($payload, $this->config->get('ali_public_key'));
    }

    /**
     * Get method config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'alipay.trade.pay';
    }

    /**
     * Get productCode config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getProductCode()
    {
        return 'FACE_TO_FACE_PAYMENT';
    }
}
