<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/13
 * Time: 11:14
 */

namespace app\index\controller;

use think\Controller;

class RandNumber extends Controller
{
//    private vars
    var $arr=array(1,2,3,4,5,6),$data = array(),$universe = 0;

//   将项目添加到列表中并定义其被选中的可能性
    public function add($data)
    {
        $this->data = $data;
        for($i=0;$i<count($data);$i++){
            $this->universe += $this->data[$i];
        }
    }

//    clears the class
    public function clear()
    {
        $this->universe = count($this->data = array());
    }

//    从列表中返回随机项
    public function get()
    {
        if (!$this->universe) return null;
        $x = round(mt_rand(1, $this->universe));
        $max = $i = 0;
        do
            $max += $this->data[$i++];
        while ($x > $max && $i < count($this->data));
        return $this->arr[$i - 1];
    }

//    return list
    public function arrList($probability)
    {
        $num = round((100 - $probability) / 5,1);
        return array($num,$num,$num,$probability,$num,100-$num*4-$probability);
    }
}