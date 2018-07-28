<?php

namespace SmartJson\Pay\Contracts;

interface GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return SmartJson\Supports\Collection|Symfony\Component\HttpFoundation\Response
     */
    public function pay($endpoint, array $payload);
}
