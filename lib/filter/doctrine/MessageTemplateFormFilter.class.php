<?php

/**
 * MessageTemplate filter form.
 *
 * @package    neskuchaik
 * @subpackage filter
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MessageTemplateFormFilter extends BaseMessageTemplateFormFilter
{
    public function configure()
    {
        $this->useFields(array('transport', 'name', 'subject', 'body'));
    }
}
