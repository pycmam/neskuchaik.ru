<?php

/**
 * хелпер для преобразования даты в удобную для чтения форму,
 * например "сегодня в 11:00", "вчера 15:10", "22 июня в 16:00"
 *
 * @package SonemEngine
 * @subpackage sfSonemBasePlugin
 * @author Рустам Миниахметов <pycmam@gmail.com>
 *
 * @todo говнокод, прикрутить i18n
 */

/**
 * название месяца
 */
function human_month($month)
{
  $months = array(1 =>
    'январе',
    'феврале',
    'марте',
    'апреле',
    'мае',
    'июне',
    'июле',
    'августе',
    'сентябре',
    'октябре',
    'ноябре',
    'декабре'
  );

  return $months[$month];
}

/**
 * возвращает читабельную дату
 *
 * @param integer временная метка
 * @param boolean показывать время
 * @param boolean показывать год, если дата в текущем году
 * @return string
 */
function human_date($timestamp, $with_time = false, $with_year = true)
{
  if (! preg_match('/^\d+^/', $timestamp))
  {
    $timestamp = strtotime($timestamp);
  }

  $timezone = sfConfig::get('app_timezome_offset', 0);

  // родительный падеж
  $month = array( 1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа',
    'сентября', 'октября', 'ноября', 'декабря');

  $date = date('Y-m-d', $timestamp + $timezone);
  $time = date('H:i', $timestamp + $timezone);
  $date_arr = explode('-', $date);

  switch(true)
  {
    case ($date == date('Y-m-d', time() + 86399 + 86399)):
      $date = 'Послезавтра';

      break;

    case ($date == date('Y-m-d', time() + 86399)):
      $date = 'Завтра';

      break;

    case ($date == date('Y-m-d', time())):
      $date = 'Сегодня';

      break;

    case ($date == date('Y-m-d', time() - 86399)):
      $date = 'Вчера';

      break;

    case ($date[0] == date('Y', time())):
      $date = sprintf('%d %s', $date_arr[2], $month[intval($date_arr[1])]);

      break;

    default:
      $date = sprintf('%d %s', $date_arr[2], $month[intval($date_arr[1])]);

  }

  if (date('Y', time()) != $date_arr[0])
  {
    $date .= ' ' . $date_arr[0];
  }

  if ($with_time)
  {
    return sprintf('%s в %s', $date, $time);
  }

  return $date;
}