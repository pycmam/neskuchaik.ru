<?php


function url_to_admin($name, $parameters)
{
  return sfProjectConfiguration::getActive()->generateAppUrl('admin', $name, $parameters);
}

function url_to_frontend($name, $parameters = array())
{
  return sfProjectConfiguration::getActive()->generateAppUrl('frontend', $name, $parameters);
}

function link_to_frontend($text, $name, $parameters, $esc = false)
{
  return '<a href="' . url_to_frontend($name, $parameters) . '">' . ($esc ? htmlspecialchars($text) : $text) . '</a>';
}

function link_to_admin($text, $name, $parameters, $esc = false)
{
  return '<a href="' . url_to_admin($name, $parameters) . '">' . ($esc ? htmlspecialchars($text) : $text) . '</a>';
}