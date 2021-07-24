<?php

    //Проверка валидности, интервалы с 00.00 по 23.59
    function validate_interval($int): bool
    {
        $interval_pattern = '/([01][0-9]|2[0-3]):[0-5][0-9]-([01][0-9]|2[0-3]):[0-5][0-9]/';
        if(preg_match($interval_pattern,$int))
        {
            if( strtotime(substr($int,6,11)) > strtotime(substr($int,0,5)) )
            {

                return true;
            }
        }
        return false;
    }

    //Добавление интервалов
    function check_new_interval($int): bool
    {
        $list = [
            '09:00-11:00',
            '11:00-13:00',
            '15:00-16:00',
            '17:00-20:00',
            '20:30-21:30',
            '21:30-22:30',
        ];

        $result = false;

        if(validate_interval($int))
        {
            for($i = 0;$i < count($list)-1; $i++)
            {
                $int_start = strtotime(substr($int,0,5)); //Проверяемый интервал начало
                $int_end = strtotime(substr($int,6,11));  //Проверяемый интервал конец
                $cur_int_end = strtotime(substr($list[$i],6,11));       //конец текущего интервала
                $next_int_start = strtotime(substr($list[$i+1],0,5));   //начало следующего интервала

                if
                (
                    (($int_start >= $cur_int_end) && ($int_start <= $next_int_start)) //Начало интервала не попадает в текущий и следующий интервал
                    &&
                    (($int_end >= $cur_int_end) && ($int_end <= $next_int_start))     //Конец интервала не попадает в текущий и следующий интервал
                )
                {
                    $result = true;
                }
            }
            if(!$result)
            {
                echo('{'.$int.'} произошло наложение, или интервал вне диапазона<br>');
            }
        }
        else
        {
            echo('{'.$int.'} интервал не прошел валидацию<br>');
        }

        return $result;
    }

?>
