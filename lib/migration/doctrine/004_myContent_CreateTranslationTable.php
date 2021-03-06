<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Migration004_myContent_CreateTranslationTable extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('my_content_translation', array(
             'id' =>
             array(
              'type' => 'integer',
              'length' => 8,
              'primary' => true,
             ),
             'title' =>
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'content' =>
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => NULL,
             ),
             'lang' =>
             array(
              'fixed' => true,
              'primary' => true,
              'type' => 'string',
              'length' => 2,
             ),
             ), array(
             'indexes' =>
             array(
             ),
             'primary' =>
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('my_content_translation');
    }
}