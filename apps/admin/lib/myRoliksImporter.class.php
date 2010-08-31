<?php

/**
 * Граббер расписания фильмов Камы
 */
class myRoliksImporter
{
    private
        $_url = 'http://chaikovskiy.roliks.com/timestable/';

    public function import()
    {
        $result = array();
        for ($day = 0; $day < 3; $day++) {
            $result += $this->_grab(strtotime(sprintf('+%d days', $day)));
        }
        return $result;
    }

    private function _grab($date)
    {
        $content = new domDocument();

        // кривая разметка камы
        @$content->loadHTML(file_get_contents($this->_url . '?date=' . date('Y-m-d', $date)));

        $rows = $content->getElementsByTagName('tr');

        $result = array();

        for ($i = 2; $i < $rows->length; $i++) {
            $cols = $rows->item($i)->getElementsByTagName('td');

            $item = array(
                'title'         => $cols->item(1)->nodeValue,
                'description'   => 'Зал: ' . $cols->item(4)->nodeValue,
                'fire_at'       => date('Y-m-d ', $date) . trim(substr($cols->item(0)->nodeValue, 2)),
            );

            if ($cols->item(4)->nodeValue == 1) {
                $item['description'] .= sprintf("\n\nЭконом: %s р.\nVIP: %s р.", $cols->item(2)->nodeValue, $cols->item(3)->nodeValue);
            } else {
                $item['description'] .= sprintf("\n\nЦена: %s р.", $cols->item(3)->nodeValue);
            }

            $result[] = $item;
        }

        return $result;
    }
}