<?php

namespace SmartJson\Pay;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use SmartJson\Pay\Contracts\GatewayApplicationInterface;
use SmartJson\Pay\Exceptions\GatewayException;
use SmartJson\Supports\Config;
use SmartJson\Supports\Str;

/**
 * @method static \SmartJson\Pay\Gateways\Alipay alipay(array $config) 支付宝
 * @method static \SmartJson\Pay\Gateways\Wechat wechat(array $config) 微信
 */
class Pay
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
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * Create a instance.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string $method
     *
     * @return GatewayApplicationInterface
     */
    protected function create($method)
    {
        !$this->config->has('log.file') ?: $this->registeLog();

        $gateway = __NAMESPACE__.'\\Gateways\\'.Str::studly($method);

        if (class_exists($gateway)) {
            return self::make($gateway);
        }

        throw new GatewayException("Gateway [{$method}] Not Exists", 1);
    }

    /**
     * Make a gateway.
     *
     * @author smartjson <me@yansonga.cn>
     *
     * @param string $gateway
     *
     * @return GatewayApplicationInterface
     */
    protected function make($gateway)
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }

        throw new GatewayException("Gateway [$gateway] Must Be An Instance Of GatewayApplicationInterface", 2);
    }

    /**
     * Registe log service.
     *
     * @author smartjson <me@smartjson.cn>
     */
    protected function registeLog()
    {
        $handler = new StreamHandler(
            $this->config->get('log.file'),
            $this->config->get('log.level', Logger::WARNING)
        );
        $handler->setFormatter(new LineFormatter("%datetime% > %level_name% > %message% %context% %extra%\n\n"));

        $logger = new Logger('smartjson.pay');
        $logger->pushHandler($handler);

        Log::setLogger($logger);
    }

    /**
     * Magic static call.
     *
     * @author smartjson <me@smartjson.cn>
     *
     * @param string $method
     * @param array  $params
     *
     * @return GatewayApplicationInterface
     */
    public static function __callStatic($method, $params)
    {
        $app = new self(...$params);

        return $app->create($method);
    }
}
