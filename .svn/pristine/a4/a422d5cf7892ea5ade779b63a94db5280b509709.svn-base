<?php
// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id$ 



class AdminModel extends RelationModel{
    protected $_link=array(
        'RoleUser'=>array(
            'mapping_type'  =>HAS_MANY,
            //关联的外键
            'mapping_key' => 'admin_id',
            'foreign_key'   =>'user_id',
            'class_name' => 'RoleUser',
            'as_fields' => 'role_id',
        ) ,
    );

} 