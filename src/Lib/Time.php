<?php
namespace Mt\Lib;

use Fw\InstanceTrait;

class Time{

    use InstanceTrait;

    public $startTime;
    public $endTime;

    function getTimestamp() {
        return microtime(true);
    }

    function startCounter() {
        $this->startTime=$this->getTimestamp();
        return $this->startTime;
    }

    function stopCounter() {
        $this->endTime=$this->getTimestamp();
    }

    function getElapsedTime() {
        return ($this->endTime)-($this->startTime);
    }

    function getExecutedTime() {
        $this->stopCounter();
        return $this->getElapsedTime();
    }

    public function getFinishEstimateTime($remain_count = 0) {
        $curr_time = $this->getTimestamp();
        $exec_time = $curr_time - $this->startTime;
        $remain_time = $remain_count * $exec_time;
        $hour   = floor($remain_time / 3600);
        $minute = floor(($remain_time - $hour*3600) / 60);
        $second = (int) $remain_time - $hour*3600 - $minute*60;

        return $hour.'h '.$minute.'m '.$second.'s';
    }

    /**
     * 将数值 0~7 转为 汉字星期
     *
     * 当 $date 为日期的时候, 将自动转换为当天中文的星期；
     * 当 $date 为数值0~7范围内的时候, 将返回指定的中文的星期。
     * 成功返回中文星期， 失败返回false。
     *
     * @paramt date|integral	$date       允许时间格式和数字格式。YYYY-mm-dd、YYYY-mm-dd HH:ii:ss、0~7
     * @paramt array			$week		重新设置星期的中文, 必须为0~7索引；
     * @return string|boolean
     */
    public static function weekNumToString( $date, $week = null ) {
        // 检查数组 和 索引
        if( !( is_array($week) && array_keys($week)===range(0, 7) ) ){
            $week = array(0=>'日', 1=>'一', 2=>'二', 3=>'三', 4=>'四', 5=>'五', 6=>'六', 7=>'日');
        }

        // 是数值 || 是日期返回星期
        if( ( is_integer( $date ) && $date >= 0 && $date <=7 ) || ( ($date = strtotime( $date ))!==false && $date = date( 'N', $date )) ) {
            return $week[$date];
        }

        return false;
    }

    /**
     * 转换单位起始时间
     *
     * 自动转换为离 {$time} 时间最近的单位时间。 如果成功将返回一个时间，否则返回false
     *
     * 例：
     * 		每天时间中15分钟为一个间隔单位, {$unit = 900}。
     * 		求 15:05:06 分位于今天的单位起始时间。
     * 解：
     * 		每15分钟一次， 那么 15:05:06 应该属于 15:00:00~15:14:59 的时间间隔。
     * 		转换后得到: 15:00:00
     *
     * @paramt date     $time       时间。格式：Y-m-d HH:ii:ss
     * @paramt int      $unit_time  间隔单位。单位：秒。
     * @paramt string   $mode       [可选]舍进方式。默认为{floor}向下舍进。可选值：ceil向上舍进、floor向下舍进
     * @return string|boolean
     */
    public static function timeToUnitTime( $time, $unit_time, $mode = 'floor' ) {

        $time = strtotime( $time );
        if( $time && $unit_time > 0 && in_array( $mode, array( 'floor', 'ceil' ) )) {
            if( $time%$unit_time != 0  ) {
                $size = $mode( $time/$unit_time );
                if( $size != 0 ) {
                    $time = $size * $unit_time;
                }
            }
            return date( 'Y-m-d H:i:s', $time );
        }

        return false;
    }

    /**
     * 时间范围转数组
     *
     * 将时间段转换为以时间单位为间隔的数字。该函数会以格林威治时间开始以间隔单位生成数值。
     * 成功返回一个一维数组，否则将返回false。
     *
     * $int = MT_Time::timeToUnitIntegral( '1970-01-01 15:00:00', '1970-01-01 16:05:00', 1800 );
     *
     * 例：
     * 		计算出 1970-01-01 15:00:00 ~ 1970-01-01 16:05:00 以每30分钟间隔的数组。
     * 解：
     * 		通过上面的公式可以得出间隔时间
     * 			1970-01-01 15:00:00 ~ 1970-01-01 15:29:59|1970-01-01 15:30:00  ==>  30
     * 			1970-01-01 15:30:00 ~ 1970-01-01 15:59:59|1970-01-01 16:00:00  ==>  31
     * 			1970-01-01 16:00:00 ~ 1970-01-01 16:29:59|1970-01-01 16:30:00  ==>  32
     *
     * @paramt time		$start_time		开始时间。格式：Y-m-d HH:ii:ss
     * @paramt time		$end_time		结束时间。格式：Y-m-d HH:ii:ss
     * @paramt int		$unit_time		间隔单位。单位：秒。
     * @return array|boolean
     */
    public static function timeToUnitIntegral( $start_time, $end_time, $unit_time ) {

        $result = false;
        $start_time = strtotime( self::timeToUnitTime( $start_time, $unit_time ) );
        $end_time   = strtotime( self::timeToUnitTime( $end_time, $unit_time ) );

        if( $start_time != false && $end_time != false ) {
            // 兼容 尾数为 59 不为 0 的情况
            if( $end_time%$unit_time != 0 ) {
                $end_time += 1;
            }

            $total = $end_time - $start_time;
            if( $total > 0 && $total%$unit_time == 0 && $start_time%$unit_time == 0 ) {
                $start = $start_time/$unit_time;
                $result = range( $start, $start + $total/$unit_time );
            }
        }

        return $result;
    }

    /**
     * 数字转时间范围
     *
     * 将数字乘以单位时间获取真正的时间范围。
     *
     * $int        = MT_Time::timeToUnitIntegral( '1970-01-01 15:00:00', '1970-01-01 16:05:00', 1800 );
     * $time_false = MT_Time::unitIntegralToTime( $int, 1800, false );
     * $time_true  = MT_Time::unitIntegralToTime( $int, 1800, true );
     * var_dump( $int );
     * var_dump( $time_false );
     * var_dump( $time_true );
     *
     * @paramt array	$integral		函数 - timeToUnitIntegral 生成的数组；
     * @paramt int		$unit_time		间隔单位。单位：秒。默认15分钟
     * @paramt boolean	$fill			[可选]结尾模式。默认为 00 模式； 设置为 true 后将返回 59 。
     * @return array|boolean
     */
    public static function unitIntegralToTime( $integral, $unit_time, $fill = false ) {

        if( $integral && is_array( $integral ) ) {
            sort( $integral );
            foreach( $integral as $item=>$int ) {
                $int = $int * $unit_time;
                $integral[$item] = array(
                    date( 'Y-m-d H:i:s', $int ),
                    date( 'Y-m-d H:i:s', $fill === true ? ( $int + $unit_time - 1 ) : ( $int + $unit_time ) )
                );
            }

            return $integral;
        }

        return false;
    }

    public function dateRangeToList( $start_date, $end_date ) {
        $start_date = date( 'Y-m-d', strtotime( $start_date ) );
        $end_date   = date( 'Y-m-d', strtotime( $end_date ) );

        $list = [];
        if($start_date && $end_date && $start_date <= $end_date) {

            for($i=0; true; $i++) {
                $list[] = date( 'Y-m-d', strtotime( "{$start_date} +{$i} Day" ) );
                if( end( $list ) >= $end_date ) {
                    break;
                }
            }
        }

        return $list;
    }
}