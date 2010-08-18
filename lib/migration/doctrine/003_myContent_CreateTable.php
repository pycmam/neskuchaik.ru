<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Migration003_myContent_CreateTable extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('my_content', array(
             'id' =>
             array(
              'type' => 'integer',
              'length' => 8,
              'autoincrement' => true,
              'primary' => true,
             ),
             'domain' =>
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'block' =>
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'url' =>
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'created_at' =>
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' =>
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' =>
             array(
             ),
             'primary' =>
             array(
              0 => 'id',
             ),
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('my_content');
    }
}