<?php

namespace Admin\Controller;

use Think\Controller;

class ArticleController extends Controller
{
	public function index()
	{
		$this->display();
	}

	public function getlist()
	{
		$currentpage = I('currentpage');
		$perpage = I('perpage');
		$fields = I('fields');
		$embed = !!I('embed');
		$order = I('order');
		if(empty($order)){
			$order = 'aid desc';
		}
		$condition = array('if_delete = 0');
		$cfield = array('cname');
		$ret = D('Article')->getList($condition,$fields,$currentpage,$perpage,$order,$embed);
		$i = 0;
		foreach ($ret['data'] as $k) {
			$k['cname'] = D('Category','Service')->getCateByid($k['cid'],$cfield);
			$ret['data'][$i++] = $k;
		}
		$this->ajaxReturn(
			array(
				'code' => 1,
				'msg' => '获取文章列表成功',
				'data' => $ret
			)
		);
	}

	/**
	 * 写文章页面
	 * @return [type] [description]
	 */
	public function create()
	{
		$this->display();
	}

	/**
	 * 创建文章
	 * @return [type] [description]
	 */
	public function addone()
	{
		$data = I('articledata');
		$data['cid'] = intval($data['cid']);
		$data['content'] = htmlspecialchars_decode($data['content']);
		$data['create_time'] = date('Y-m-d H:i:s',time());
		$data['update_time'] = date('Y-m-d H:i:s',time());
		try{
			$res = D('Article')->addone($data);
			$this->ajaxReturn(array('code'=>1,'msg'=>'创建成功'));
		}catch(Exception $e){
			$this->ajaxReturn(array('code'=>0,'msg'=>'创建失败'));
		}
	}

	/**
	 * 修改文章页面
	 * @return [type] [description]
	 */
	public function edit()
	{
		$aid = intval(I('aid'));
		$condition = array('aid' => $aid);
		$ret = D('Article')->getone($condition);
		$this->ajaxReturn(array('code' => 1,'msg' => '获取文章成功','data' => $ret));
	}

	/*public function getone()
	{
		$aid = intval(I('aid'));
		$condition = array('aid' => $aid);
		$ret = D('Article')->getone($condition);
		$this->ajaxReturn(array('code' => 1,'msg' => '获取文章成功','data' => $ret));
	}*/

	/**
	 * [update description]
	 * @return [type] [description]
	 */
	public function updateone()
	{
		$aid = I('aid');
		if(empty($aid)){
			$this->ajaxReturn(array('code'=>-1,'msg'=>'para error'));
		}
		$condition = array('aid' => $aid);
		$data['title'] = I('atitle');
		$data['cid'] = I('cid');
		$data['content'] = I('contents');
		$data['update_time'] = date('Y-m-d H:i:s',time());
		$ret = D('Article')->update($condition,$data);
		if($ret){
			$this->ajaxReturn(array('code'=>1,'msg'=>'更新成功'));
		}else{
			$this->ajaxReturn(array('code'=>0,'msg'=>'更新失败'));
		}
	}

	/**
	 * 删除操作
	 * @return [type] [description]
	 */
	public function delete()
	{
		$aid = intval(I('aid'));
		$condition = array('aid' => $aid);
		if(empty($aid)){
			$this->ajaxReturn(array('code' => -1,'msg' => 'para error'));
		}
		$ret = D('Article')->updelete($condition);
		if($ret){
			$this->ajaxReturn(array('code'=>1,'msg'=>'删除成功'));
		}else{
			$this->ajaxReturn(array('code'=>0,'msg'=>'删除失败'));
		}
	}
}