<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use App\Logging\ColorLineFormatter;
use \Bramus\Monolog\Formatter\ColoredLineFormatter;
use \Bramus\Monolog\Formatter\ColorSchemes\TrafficLight;


class CustomizeFormatter
{
    private $log_format = "%datetime% [%level_name%] %extra% %message% %context%\n";
    private $date_format = 'Y-m-d H:i:s';


    /**

     * 渡されたロガーインスタンスのカスタマイズ
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $formatter = new LineFormatter($this->log_format,$this->date_format,true,true);
        $formatter = new ColoredLineFormatter(new TrafficLight(),$this->log_format,$this->date_format,true,true);
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
            //$handler->setFormatter($coloredLineFormatter);
        }
    }
}
