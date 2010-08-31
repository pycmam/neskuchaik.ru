<?php

/**
 * Хелпер общего назначения
 */
class H
{
    /**
     * Преобразовать все элементы полученного массива в int
     *
     * @param  array $value
     * @return array
     */
    public static function intArray($value)
    {
        if (!$value || !is_array($value)) {
            return array();
        }

        return array_keys(array_flip(array_map('intval', array_map('strval', $value))));
    }


    /**
     * Сгруппировать элементы массива
     */
    public static function groupArray(array $list, $keyColumn, $valuesColumn)
    {
        $result = array();
        foreach ($list as $row) {
            $result[$row[$keyColumn]][] = $row[$valuesColumn];
        }

        return $result;
    }


    /**
     * Мерджит вложенные массивы в корневой добавляя префикс к ключам
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    public static function simplifyArray($array, $prefix = '')
    {
        $result = array();
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $result += self::simplifyArray($item, $prefix . $key . '_');
            } else {
                $result[$prefix . $key] = $item;
            }
        }
        return $result;
    }


    /**
     * Выбрать множественную форму склонения из словаря
     *
     * @param  string $text      - ключ словаря
     * @param  int    $number    - число
     * @param  string $catalogue - словарь
     * @param  array  $args      - аргументы оригинального хелпера __()
     * @return string
     */
    public static function pluralForm($text, $number, $args = array(), $catalogue = 'messages')
    {
        $index = abs((int)$number);
        if ($index > 100) $index %= 100;
        if ($index > 20)  $index %= 10;

        switch ($index) {
            case 0:
                $index = 0;
                break;
            case 1:
                $index = 1;
                break;
            case 2:
            case 3:
            case 4:
                $index = 2;
                break;
            default:
                $index = 5;
        }

        $args = array_merge($args, array('%n%' => $number));
        return format_number_choice($text, $args, $index, $catalogue);
    }

}
