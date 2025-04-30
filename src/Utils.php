<?php

namespace Ren;

use \DOMDocument;

class Utils
{
    public static function clearInput($string)
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }

    public static function resposnePlainText($response)
    {
        if (empty($response)) {
            return "<p>Empty</p>";
        }
        ob_start();
?>
        <table>
            <?php foreach ($response[0] as $prop => $value): ?>
                <th><?php echo $prop ?></th>
            <?php endforeach; ?>
            <?php foreach ($response as $row): ?>
                <tr>
                    <?php foreach ($row as $col): ?>
                        <td><?php echo $col ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
<?php
        return ob_get_clean();
    }

    public static function responseXML($response)
    {
        $dom = new DOMDocument();
        if (empty($response)) {
            $dom->appendChild($dom->createElement("response", "Empty"));
            return $dom->saveXML();
        }
        $nodeResponse = $dom->createElement("response");
        foreach ($response as $obj => $value) {
            $row = $dom->createElement("row");
            foreach ($value as $key => $pair) {
                $row->appendChild($dom->createElement($key, $pair));
            }
            $nodeResponse->appendChild($row);
        }
        $dom->appendChild($nodeResponse);
        return $dom->saveXML();
    }

    public static function responseJSON($response)
    {
        return json_encode($response);
    }
}
