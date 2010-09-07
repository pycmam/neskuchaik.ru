<?php
/**
 * Рисовальщик форм
 *
 * @author Max <maxim.olenik@gmail.com>
 */
class sfWidgetFormSchemaFormatterMyList extends sfWidgetFormSchemaFormatter
{
    /**
     * Config props
     */
    protected
        $rowFormat       = "<li class='form-item'>\n    %label%\n    %field%\n    %help%\n    %error%%hidden_fields%</li>\n",
        $errorRowFormat  = "<li>\n%errors%</li>\n",
        $helpFormat      = '<div class="help">%help%</div>',
        $decoratorFormat = "<ul>\n    %content%</ul>";

    /**
     * sfValidatorSchema
     */
    private $_validatorSchema = null;


    /**
     * Зареристрировать набор валидаторов
     *
     * @param sfValidatorSchema $schema
     * @return void
     */
    public function setValidatorSchema(sfValidatorSchema $schema)
    {
        $this->_validatorSchema = $schema;
    }


    /**
     * Создать HTML-тег LABEL
     *
     * Помечает "label" классом "required" в соответствии с настройками валидатора
     * Если это чекбокс, тогда помечает его классом "checkbox"
     *
     * @return string
     */
    public function generateLabel($name, $attributes = array())
    {
        if (!empty($attributes['class'])) {
            $class = explode(' ', $attributes['class']);
        } else {
            $class = array();
        }

        // Required
        if ($this->_validatorSchema && $this->_validatorSchema[$name]->getOption('required')) {
            $class[] = 'required';
        }

        // Checkbox
        if ($this->widgetSchema[$name] instanceof sfWidgetFormInputCheckbox) {
            $class[] = 'checkbox';
        }

        if ($class) {
            $attributes['class'] = implode(' ', $class);
        }
        return parent::generateLabel($name, $attributes);
    }


    /**
     * Создать содержимое для тега LABEL
     *
     * Создает имя по аналогии с ID
     * К обязательным полям добавляет "*"
     *
     * @return string
     */
    public function generateLabelName($name)
    {
        $labels = $this->widgetSchema->getLabels();

        // не генерировать название поля, если оно уже задано
        if (isset($labels[$name])) {
            $label = $labels[$name];
        } else {
            $label = 'form_field: ' . $this->widgetSchema->generateId($this->widgetSchema->generateName($name));
        }

        $label = $this->translate($label);

        if ($this->_validatorSchema && $this->_validatorSchema[$name]->getOption('required')) {
            $label .= '<span class="required">*</span>';
        }

        return $label;
    }


    /**
     * Отрисовать поле формы
     *
     * Хак, чтобы поменять местами checkbox и label
     */
    public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
    {
        if (strpos($field, 'checkbox') !== false) {
            return parent::formatRow($field, $label, $errors, $help, $hiddenFields);
        }

        return parent::formatRow($label, $field, $errors, $help, $hiddenFields);
    }

}
