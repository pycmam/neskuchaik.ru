<?php

/**
 * Для отрисовки полей формы в одну строку
 */
class sfWidgetFormSchemaFormatterInline extends sfWidgetFormSchemaFormatter
{
    protected
        $rowFormat       = '<td>%error%%field%%hidden_fields%</td>',
        $errorRowFormat  = '', // не выводить Global Errors
        $decoratorFormat = '%content%';
}
