<?php

namespace app\index\model;

/**
* 张喜硕
* 课程学期类
* @getDays 获取天
*/
class CourseTerm
{

    function __construct($Courseid, $Termid){
        $this->Course = $Courseid;
        $this->Term = $Termid;
    }

    public function getDays(){
        $days = [];
        for($temp = 1 ; $temp <= 7 ; $temp ++) {
            $Day = new Day();
            $Day->Course = $this->Course;
            $Day->Term = $this->Term;
            $Day->Day = $temp;
            array_push($days, $Day);
        }

        return $days;
    }
}