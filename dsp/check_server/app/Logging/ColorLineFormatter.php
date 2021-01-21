<?php

namespace App\Logging;

use Bramus\Monolog\Formatter\ColorSchemes\DefaultScheme;

// quote by:
// https://github.com/bramus/monolog-colored-line-formatter/blob/master/src/Formatter/ColoredLineFormatter.php
class ColorLineFormatter extends CustomLineFormatter
{
    private $colorScheme = null;

    public function getColorScheme()
    {
        if (!$this->colorScheme) {
            $this->colorScheme = new DefaultScheme();
        }

        return $this->colorScheme;
    }

    public function format(array $record) : string
    {
        $output = parent::format($record);

        $colorScheme = $this->getColorScheme();
        return $colorScheme->getColorizeString($record['level']).trim($output).$colorScheme->getResetString()."\n";
    }
}
