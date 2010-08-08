<?php
require_once dirname(__FILE__).'/../../bootstrap/all.php';



/**
 * myBaseTable
 */
class helper_myBaseTableTest extends myUnitTestCase
{
    /**
     * Рассчитать кол-во дней между двумя датами
     */
    public function testDateDiff()
    {
        $testingPlan = array(
            '2009-01-01---2009-01-01'                   => 0,
            '2009-01-01 00:00:00---2009-01-01 23:59:59' => 0,
            '2009-01-02---2009-01-01'                   => 1,
            '2009-01-02 10:00:00---2009-01-01'          => 1,
            '2008-12-31---2009-01-02'                   => -2,
        );


        foreach ($testingPlan as $dates => $expectedResult) {
            list($startDate, $endDate) = explode('---', $dates);

            $this->assertEquals($expectedResult, myBaseTable::dateDiff($startDate, $endDate),
                "Expected diff `{$expectedResult}` for dates {$startDate} - {$endDate}");
        }

        $this->assertSame(
            myBaseTable::dateDiff('2009-01-05', '2009-01-01'),
            myBaseTable::dateDiff('2009-01-05', '2009-01-01')
        );
    }
}
