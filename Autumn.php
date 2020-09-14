<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/13
 * Time: 10:17
 */

namespace app\index\controller;

use think\Controller;

class Autumn extends Controller
{

    public function index()
    {
        $uid = $this->request->param('uid');
        /**
         * 根据uid查询用户奖项记录的次数，判断是否还有次数
         * 没有次数返回exit(json_encode(array('code' => 0, 'number' => [], 'prize' => [])));
         *数据库获取每个四出现的概率
         * 限制条件=>
         * min：0，max：100，单位：%
         * one>=two>=three>=four>=five>=six
         */
        $one = 20;//第1个四的概率
        $two = 20;//第2个四的概率
        $three = 20;//第3个四的概率
        $four = 20;//第4个四的概率
        $five = 20;//第5个四的概率
        $six = 20;//第6个四的概率
        $probability = [$one, $two, $three, $four, $five, $six];
        //6个骰子
        $arr = [];

        $randNumber = new RandNumber();
        for ($i = 0; $i < count($probability); $i++) {
            $randNumber->add($randNumber->arrList($probability[$i]));//生成数组,加入随机列表
            $arr[] = $randNumber->get();//获取数字
            $randNumber->clear();//初始化
        }
        shuffle($arr);//随机排列数组
        /**
         *数据库获取奖项列表
         * 字段id，title，name, content，type，pic
         */
        $prizeList = [
            array('pic' => '../../images/activity16.png', 'title' => '秀才', 'name' => '一秀','content' => '价值599的环鼓夜游亲子豪华套餐一份','type' => 1),
            array('pic' => '../../images/activity16.png', 'title' => '举人', 'name' => '二举','content' => '价值599的环鼓夜游情侣套餐一份','type' => 2),
            array('pic' => '../../images/activity16.png', 'title' => '进士', 'name' => '四进','content' => '价值599的环鼓夜游单人门票一张','type' => 3),
            array('pic' => '../../images/activity16.png', 'title' => '探花', 'name' => '三红','content' => '价值599的环鼓夜游单人门票一张','type' => 4),
            array('pic' => '../../images/activity16.png', 'title' => '榜眼', 'name' => '对堂','content' => '价值999的环鼓夜游单人门票一张','type' => 5),
            array('pic' => '../../images/activity16.png', 'title' => '一等奖（状元）', 'name' => '四点红','content' => '价值1999的环鼓夜游单人门票一张','type' => 6),
            array('pic' => '../../images/activity16.png','title' => '状元', 'name' => '五子登科', 'content' => '五子登科奖品内容', 'type' => 7),
            array('pic' => '../../images/activity16.png','title' => '状元', 'name' => '五红', 'content' => '五红奖品内容', 'type' => 8),
            array('pic' => '../../images/activity16.png','title' => '状元', 'name' => '六杯黑', 'content' => '六杯黑奖品内容', 'type' => 9),
            array('pic' => '../../images/activity16.png','title' => '状元', 'name' => '遍地锦', 'content' => '遍地锦奖品内容', 'type' => 10),
            array('pic' => '../../images/activity16.png','title' => '状元', 'name' => '六杯红', 'content' => '六杯红奖品内容', 'type' => 11),
            array('pic' => '../../images/activity16.png','title' => '状元', 'name' => '状元插金花', 'content' => '状元插金花奖品内容', 'type' => 12),
        ];
        $prize = $this->getPrize($arr, $prizeList);

        /**
         * 保存用户奖项记录
         * id,  user_id: $uid,type:$prize['type'],name:$prize['name'],number: implode('',$arr),status: 0,code:time().$this->get_order()
         * status=>0未核销，1为已核销
         * code核销码
         */

        exit(json_encode(array('code' => 1, 'number' => $arr, 'prize' => $prize)));
    }

    //获取奖项
    protected function getPrize($arr, $prize)
    {
        $one = array_key_exists(1, array_count_values($arr)) ? array_count_values($arr)[1] : 0;
        $two = array_key_exists(2, array_count_values($arr)) ? array_count_values($arr)[2] : 0;
        $three = array_key_exists(3, array_count_values($arr)) ? array_count_values($arr)[3] : 0;
        $four = array_key_exists(4, array_count_values($arr)) ? array_count_values($arr)[4] : 0;
        $five = array_key_exists(5, array_count_values($arr)) ? array_count_values($arr)[5] : 0;
        $six = array_key_exists(6, array_count_values($arr)) ? array_count_values($arr)[6] : 0;
        $type = 0;

        if ($four == 1 && ($one == 0 || $two == 0 || $three == 0 || $five == 0 || $six == 0)) {
            $type = 1;//一秀
        } elseif ($four == 1 && $one == 1 && $two == 1 && $three == 1 && $five == 1 && $six == 1) {
            $type = 5;//对堂
        } elseif ($four == 2) {
            $type = 2;//二举
        } elseif ($four == 3) {
            $type = 4;//三红
        } elseif ($one == 4 || $two == 4 || $three == 4 || $five == 4 || $six == 4) {
            $type = 3;//四进
        } elseif ($four == 4 && $one != 2) {
            $type = 6;//四点红
        } elseif ($four == 4 && $one == 2) {
            $type = 12;//状元插金花
        } elseif ($one == 5 || $two == 5 || $three == 5 || $five == 5 || $six == 5) {
            $type = 7;//五子登科
        } elseif ($four == 5) {
            $type = 8;//五红
        } elseif ($two == 6 || $three == 6 || $five == 6 || $six == 6) {
            $type = 9;//六杯黑
        } elseif ($one == 6) {
            $type = 10;//遍地锦
        } elseif ($four == 6) {
            $type = 11;//六杯红
        }

        foreach ($prize as $key => $value) {
            if ($type == $value['type']) {
                if ($type == 0) {
                    $value['prizeState'] = 0;
                } elseif ($type == 12) {
                    $value['prizeState'] = 2;
                } else {
                    $value['prizeState'] = 1;
                }
                return $value;
            }
        }

        return ['title' => '', 'name' => '', 'content' => '', 'prizeState' => 0, 'type' => 0];
    }

    protected function get_order($length = 6) {
        $chars = '0123456789';
        $password = '';
        for($i = 0; $i < $length; $i++)
        {
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $password;
    }

}