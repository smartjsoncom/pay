<?php

namespace SmartJson\Pay\Gateways\Wechat;

use SmartJson\Supports\Collection;

class PosGateway extends Gateway
{
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
        unset($payload['trade_type'], $payload['notify_url']);

        return $this->preOrder('pay/micropay', $payload);
    }

    /**
     * Get trade type config.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return string
     */
    protected function getTradeType(): string
    {
        return 'MICROPAY';
    }
}
