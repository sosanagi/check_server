<?php

namespace App\Logging\Formatters;

use Monolog\Formatter\LineFormatter;

class CustomLineFormatter extends LineFormatter
{
    public function __construct()
    {
        // 2020-10-13 17:12:15.375 [local.INFO] log message という形式で出力
        $lineFormat = "%datetime% [%channel%.%level_name%] %message%" . PHP_EOL;
        $dateFormat = "Y-m-d H:i:s.v"; // PHP: DateTime::format

        parent::__construct($lineFormat, $dateFormat, true, true);
    }

    public function format(array $record): string
    {
        // var_dump($record);
        $output = parent::format($record);
        // var_dump($output);

        return $output;
    }
}
