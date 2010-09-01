<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Migration021_Message_CreateTable extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('app_messages', array(
             'id' => array(
                'type'          => 'integer',
                'length'        => 20,
                'autoincrement' => true,
                'primary'       => true,
             ),
             'transport' => array(
                'type'          => 'enum',
                'values'        => array('email', 'icq', 'jabber', 'sms'),
                'notnull'       => true,
             ),
             'to' => array(
                'type'          => 'string',
                'notnull'       => true,
                'length'        => 255,
             ),
             'message' => array(
                'type'          => 'text',
                'notnull'       => true,
             ),
             'created_at' => array(
                'type'          => 'timestamp',
             ),
             'updated_at' => array(
                'type'          => 'timestamp',
             ),
         ),
        array(
            'type'    => 'INNODB',
            'charset' => 'utf8',
        ));
    }

    public function down()
    {
        $this->dropTable('app_messages');
    }
}