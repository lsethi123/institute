<?php
     
	/**
	 * checkDateFormate()
	 * 
	 * @param mixed $date_input Date Input To Validate
	 * @param string $seprator Date Seperator [Optional] Make sure to escape it
	 * @param mixed $format Date Format DateUtils::DDMMYYYY
	 * @return boolean
	 */
	function checkDateFormate($date_input, $seprator = '\/', $format = DateUtils::DDMMYYYY)
    {
        switch($format)
        {
            case DateUtils::DDMMYYYY:
                $reg_pattern = "/^([0-9]{1,2})$seprator([0-9]{1,2})$seprator([0-9]{2,4})$/";
                if(preg_match($reg_pattern, $date_input, $date_parts))
                {
                    return checkdate($date_parts[2],$date_parts[1],$date_parts[3]);
                }
                else
                {
                    return false;
                }
            break;
            case DateUtils::MMDDYYYY:
                $reg_pattern = "/^([0-9]{1,2})$seprator([0-9]{1,2})$seprator([0-9]{2,4})$/";
                if(preg_match($reg_pattern, $date_input, $date_parts))
                {
                    return checkdate($date_parts[1],$date_parts[2],$date_parts[3]);
                }
                else
                {
                    return false;
                }
            break;
            case DateUtils::YYYYMMDD:
                $reg_pattern = "/^([0-9]{2,4})$seprator([0-9]{1,2})$seprator([0-9]{1,2})$/";
                if(preg_match($reg_pattern, $date_input, $date_parts))
                {
                    return checkdate($date_parts[2],$date_parts[3],$date_parts[1]);
                }
                else
                {
                    return false;
                }
            break;
            case DateUtils::YYYYDDMM:
                $reg_pattern = "/^([0-9]{2,4})$seprator([0-9]{1,2})$seprator([0-9]{1,2})$/";
                if(preg_match($reg_pattern, $date_input, $date_parts))
                {
                    return checkdate($date_parts[3],$date_parts[2],$date_parts[1]);
                }
                else
                {
                    return false;
                }
            break;
            default:
                $reg_pattern = "/^([0-9]{1,2})$seprator([0-9]{1,2})$seprator([0-9]{2,4})$/";
                if(preg_match($reg_pattern, $date_input, $date_parts))
                {
                    return checkdate($date_parts[2],$date_parts[1],$date_parts[3]);
                }
                else
                {
                    return false;
                }
            break;
        }
    }
    
    function appendZero($v)
    {
        //preg_match("/^([0-9]{2})$/",2)
        if(strlen($v) == 1)
            return '0'.$v;
        else
            return $v;
    }
    
    function checkdate_util($MM, $DD, $YY)
    {
        return checkdate(appendZero($MM), appendZero($DD), $YY);
    }
    
    class DateUtils{
        const DDMMYYYY = 1;
        const MMDDYYYY = 2;
        const YYYYMMDD = 3;
        const YYYYDDMM = 4;
    }
?>