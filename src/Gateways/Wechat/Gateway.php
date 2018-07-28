<?php

namespace SmartJson\Pay\Gateways\Wechat;

use SmartJson\Pay\Contracts\GatewayInterface;
use SmartJson\Pay\Gateways\Wechat;
use SmartJson\Pay\Log;
use SmartJson\Supports\Collection;
use SmartJson\Supports\Config;

abstract class Gateway implements GatewayInterface
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

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
        $this->mode = $this->config->get('mode', Wechat::MODE_NORMAL);
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
    abstract public function pay($endpoint, array $payload);

    /**
     * Get trade type config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    abstract protected function getTradeType();

    /**
     * Preorder an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return Collection
     */
    protected function preOrder($endpoint, $payload): Collection
    {
        $payload['sign'] = Support::generateSign($payload, $this->config->get('key'));

        Log::debug('Pre Order:', [$endpoint, $payload]);

        return Support::requestApi($endpoint, $payload, $this->config->get('key'));
    }
}
