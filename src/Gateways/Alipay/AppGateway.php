<?php

namespace SmartJson\Pay\Gateways\Alipay;

use Symfony\Component\HttpFoundation\Response;
use SmartJson\Pay\Contracts\GatewayInterface;
use SmartJson\Pay\Log;
use SmartJson\Supports\Config;

class AppGateway implements GatewayInterface
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
     * @return Response
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['method'] = $this->getMethod();
        $payload['biz_content'] = json_encode(array_merge(
            json_decode($payload['biz_content'], true),
            ['product_code' => $this->getProductCode()]
        ));
        $payload['sign'] = Support::generateSign($payload, $this->config->get('private_key'));

        Log::debug('Paying An App Order:', [$endpoint, $payload]);

        return Response::create(http_build_query($payload));
    }

    /**
     * Get method config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'alipay.trade.app.pay';
    }

    /**
     * Get productCode method.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getProductCode(): string
    {
        return 'QUICK_MSECURITY_PAY';
    }
}
