<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use app\index\model\Contribution;

/**
 * 贡献值系统控制器
 * zhangxishuo
 */

class ContributionController extends Controller {

    /**
     * 以下为课表管理系统中使用的方法
     * zhangxishuo
     */

    /**
     * 贡献值管理-主页
     * zhangxishuo
     */
    public function index() {
        $users = User::getUsualUsers();                      // 获取本系统中状态为正常的用户
        $this->assign('users', $users);                      // 传入视图层
        return $this->fetch();
    }

    /**
     * 查看详细信息
     * zhangxishuo
     * Controller类中无view方法，该类的一个属性为$view
     */
    public function view() {
        $name = $this->request->param('username');           // 获取url中的参数username
        $user = User::get($name);                                  // 获取用户
        $size = config('paginate')['list_rows'];
        $info = Contribution::searchByUsername($name, $size);      // 查询该用户相关的贡献值记录
        $this->assign('user', $user);                        // 传入视图层
        $this->assign('info', $info);                        // 传入视图层
        return $this->fetch();
    }

    /**
     * 修改贡献值
     * zhangxishuo
     */
    public function revise() {
        $name = $this->request->param('username');           // 获取url中的参数username
        $user = User::get($name);                                  // 获取用户
        $this->assign('user', $user);                        // 传入视图层
        return $this->fetch();
    }

    /**
     * 保存贡献值
     * zhangxishuo
     */
    public function save() {
        $name   = $this->request->param('username');
        $action = $this->request->post('action');
        $value  = $this->request->post('value');
        $source = '贡献值修改';
        $remark = $this->request->post('remark');
        if ($action === 'minus') {
            $value = -$value;
        }
        $result = Contribution::revise($name, $value, $source, $remark);
        if ($result['operate']) {
            $this->success($result['message'], 'contribution/index');
        } else {
            $this->error($result['message'], 'contribution/index');
        }
    }

    /**
     * 以下为对Github提供的接口
     */

    /**
     * 解析Github数据的接口
     * zhangxishuo
     */
    public function countContribution() {
        $json = file_get_contents('php://input');            // 获取传来的json数据
        Contribution::count($json);                          // 调用count方法计数
    }
}
