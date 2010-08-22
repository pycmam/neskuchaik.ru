<?php

/**
 * Выбор иконки
 */
class myWidgetFormIcon extends sfWidgetFormInputHidden
{
    /**
     * Config
     *
     * @param array $options
     * @param array $attributes
     */
    protected function configure($options = array(), $attributes = array())
    {
        parent::configure($options, $attributes);
        $this->addOption('path', '/images/marker');
        $this->addOption('icons', array());
        $this->addOption('target', '#point_icon');
        $this->setOption('is_hidden', false);

    }

    /**
     * Отрисовка
     *
     * @param mixed $name
     * @param mixed $value
     * @param mixed $attributes
     * @param mixed $errors
     * @return string
     */
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $js = '
<script type="text/javascript">
$(function(){
    $(".icon-changer img").click(function(){
        $("'. $this->getOption('target'). '").val($(this).attr("alt"));
        $("img", $(this).parent()).removeClass("selected");
        $(this).addClass("selected");
    });
});
</script>
<div class="icon-changer" title="Выбрать иконку">
';
        foreach ($this->getOption('icons') as $icon) {
            if ($value == $icon) {
                $class = ' class="selected"';
            } else {
                $class = '';
            }

            $js .= sprintf('<img%3$s src="%1$s/%2$s.png" alt="%2$s" />', $this->getOption('path'), $icon, $class);
        }

        $js .= '</div>';

        return $js . parent::render($name, $value, $attributes = array(), $errors = array());
    }
}
