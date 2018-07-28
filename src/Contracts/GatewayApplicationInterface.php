<?php

namespace SmartJson\Pay\Contracts;

interface GatewayApplicationInterface
{
    /**
     * To pay.
     *
     * @author smartjson <me@yansonga.cn>
     *
     * @param string $gateway
     * @param array  $params
     *
     * @return SmartJson\Supports\Collection|Symfony\Component\HttpFoundation\Response
     */
    public function pay($gateway, $params);

    /**
     * Query an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string|array $order
     *
     * @return SmartJson\Supports\Collection
     */
    public function find($order);

    /**
     * Refund an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param array $order
     *
     * @return SmartJson\Supports\Collection
     */
    public function refund($order);

    /**
     * Cancel an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string|array $order
     *
     * @return SmartJson\Supports\Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string|array $order
     *
     * @return SmartJson\Supports\Collection
     */
    public function close($order);

    /**
     * Verify a request.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return SmartJson\Supports\Collection
     */
    public function verify();

    /**
     * Echo success to server.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function success();
}
