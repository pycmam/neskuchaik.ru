<?php

/**
 * Comment form.
 *
 * @package    neskuchaik
 * @subpackage form
 * @author     pycmam <pycmam@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentForm extends BaseCommentForm
{
    public function configure()
    {
        $this->useFields(array('comment'));
    }
}
