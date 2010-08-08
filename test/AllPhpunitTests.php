<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');


class AllTests extends PHPUnit_Framework_TestSuite
{
    /**
     * TestSuite
     */
    public static function suite()
    {
        $suite = new AllTests('PHPUnit');

        $base  = dirname(__FILE__);
        $files = sfFinder::type('file')->name('*Test.php')->in(array(
            DIR.'/plugins/sfPhpunitPlugin/test',
            $base.'/unit',
            $base.'/functional',
        ));

        foreach ($files as $file) {
            $suite->addTestFile($file);
        }

        return $suite;
    }

}
