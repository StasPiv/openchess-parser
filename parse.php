<?php
/**
 * Created by openchess.
 * User: ssp
 * Date: 05.08.16
 * Time: 18:20
 */

require_once 'vendor/autoload.php';

use StasPiv\BaseParsers\OpenChess\Parser;

$parser = new Parser();
$parser->parse();