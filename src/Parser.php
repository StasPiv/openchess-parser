<?php
/**
 * Created by openchess.
 * User: ssp
 * Date: 05.08.16
 * Time: 18:19
 */

namespace StasPiv\BaseParsers\OpenChess;

use League\CLImate\CLImate;
use League\CLImate\TerminalObject\Dynamic\Progress;
use Sunra\PhpSimple\HtmlDomParser;

class Parser
{
    public function parse()
    {
        $climate = new CLImate();

        $baseUrl = 'http://www.openchess.ru/pgn.php?nom=';

        $pgn = '';

        $startNumber = 45080;
        $endNumber = 55089;

        /** @var Progress $progress */
        $progress = $climate->progress()->total($endNumber - $startNumber);

        for ($gameNumber = $startNumber; $gameNumber < $endNumber; $gameNumber++) {
            $progress->current($gameNumber - $startNumber);
            $dom = HtmlDomParser::file_get_html('' . $baseUrl . $gameNumber);
            $elems = $dom->find('META');

            preg_match('/URL=(.+)/', $elems[0]->content, $matches);

            if (empty($matches)) {
                continue;
            }

            $str = 'http://www.openchess.ru/' . preg_replace('/\s/', '%20', $matches[1]);

            $content = file_get_contents($str);

            if (empty($content)) {
                continue;
            }

            $pgn .= PHP_EOL . $content;
        }

        file_put_contents('pgn.pgn', $pgn);

    }
}