<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Migration005_CreateForeignKeys extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('my_content_translation', 'my_content_translation_id_my_content_id', array(
             'name' => 'my_content_translation_id_my_content_id',
             'local' => 'id',
             'foreign' => 'id',
             'foreignTable' => 'my_content',
             'onUpdate' => 'CASCADE',
             'onDelete' => 'CASCADE',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('my_content_translation', 'my_content_translation_id_my_content_id');
    }
}