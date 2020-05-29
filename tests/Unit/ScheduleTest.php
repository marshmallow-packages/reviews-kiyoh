<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Marshmallow\HelperFunctions\Facades\Date;

class ScheduleTest extends TestCase
{
    protected $test_start = '2020-05-25';
    protected $add_days = 3;

    protected function setupWeekendDays()
    {
        Date::setWeekend([
            Date::saterday(),
            Date::sunday(),
        ]);
    }

    public function testMondayReturnsThursday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start),
            $this->add_days,
        );

        $this->assertEquals($date->isoFormat('d'), 4);
        $this->assertEquals($date->format('d-m'), '28-05');
        $this->assertEquals($date->diff($start)->d, 3);
    }
    public function testTuesdayReturnsFriday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start)->addDays(1),
            $this->add_days,
        );
        $this->assertEquals($date->isoFormat('d'), 5);
        $this->assertEquals($date->format('d-m'), '29-05');
        $this->assertEquals($date->diff($start)->d, 3);
    }
    public function testWednesdayReturnsMonday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start)->addDays(2),
            $this->add_days,
        );
        $this->assertEquals($date->isoFormat('d'), 1);
        $this->assertEquals($date->format('d-m'), '01-06');
        $this->assertEquals($date->diff($start)->d, 5);
    }
    public function testThursdayReturnsTuesday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start)->addDays(3),
            $this->add_days,
        );
        $this->assertEquals($date->isoFormat('d'), 2);
        $this->assertEquals($date->format('d-m'), '02-06');
        $this->assertEquals($date->diff($start)->d, 5);
    }
    public function testFridayReturnsWednesday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start)->addDays(4),
            $this->add_days,
        );
        $this->assertEquals($date->isoFormat('d'), 3);
        $this->assertEquals($date->format('d-m'), '03-06');
        $this->assertEquals($date->diff($start)->d, 5);
    }
    public function testSaturdayReturnsThursday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start)->addDays(5),
            $this->add_days,
        );

        $this->assertEquals($date->isoFormat('d'), 3);
        $this->assertEquals($date->format('d-m'), '03-06');
        $this->assertEquals($date->diff($start)->d, 4);
    }
    public function testSundayReturnsThursday()
    {
        $this->setupWeekendDays();
        $date = Date::addDaysWithoutWeekend(
            $start = Carbon::parse($this->test_start)->addDays(6),
            $this->add_days,
        );
        $this->assertEquals($date->isoFormat('d'), 3);
        $this->assertEquals($date->format('d-m'), '03-06');
        $this->assertEquals($date->diff($start)->d, 3);
    }
}
