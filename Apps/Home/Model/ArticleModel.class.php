<?php

namespace Home\Model;

use Think\Model;

class ArticleModel extends CommonModel{
	protected $tableName = "article";
	protected $fieldsName = array(
		'aid' => '文章编号',
		'title' => '文章标题',
		'plaintxt' => '摘要',
		'content' => '文章内容',
		'if_delete' => '是否已删除',
		'cuid' => '作者编号',
		'cid' => '分类编号',
		'rnum' => '阅读次数',
		'create_time' => '创建时间',
		'update_time' => '更新时间',
	);
}