<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/13
 * Time: 19:41
 */

namespace app\index\controller;

use think\Controller;

class AutumnKit extends Controller
{
    public function index()
    {
        /**
         * 数据库获取活动奖品列表
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

        $active = [
            'time' => '2020年11月21日 14:00 ~ 2020年12月21日 14:00',
            'rule' => '购买船票或餐食或商品满300元可获得一次抽奖机会',
            'article' => "<p style='margin-bottom:20px;'>活动要凑齐对应点数可获得相应奖品，参与活动有一次摇骰机会，购买商品产品也可获得摇骰机会。</p><img src='../../images/activity17.png'></img>",
        ];

        exit(json_encode(array('active_list' => $prizeList, 'active' => $active)));

    }

    public function prize()
    {
        /**
         *数据库获取用户奖项列表
         * type!=0,user_id = $uid
         * status=>0未核销，1为已核销
         */
        $uid = $this->request->param('uid');
        $prize = [
            array('id'=>1,'user_id' => '10', 'name' => '一秀', 'number' => '124211', 'type' => 1, 'status' => 0),
            array('id'=>2,'user_id' => '10', 'name' => '一秀', 'number' => '124311', 'type' => 1, 'status' => 1),
        ];

        exit(json_encode(array('prize' => $prize)));
    }

    public function detail()
    {
        /**
         * 奖品明细
         * 数据库获取用户奖项列表
         * id=>$id
         * 根据type连表查询奖项列表
         */
        $id = $this->request->param('id');
        $prize = ['id'=>1,'user_id' => '10', 'name' => '一秀', 'number' => '124211', 'type' => 1, 'status' => 0,'code'=>'1600004643377941'];
        $prizeList = ['pic' => '../../images/activity16.png', 'title' => '秀才', 'name' => '一秀','content' => '价值599的环鼓夜游亲子豪华套餐一份','type' => 1];

        exit(json_encode(array('prize' => $prize,'prize_list'=>$prizeList)));
    }

}