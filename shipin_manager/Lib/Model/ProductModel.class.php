<?php
// +----------------------------------------------------------------------
// | 时品
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://m.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id$ 


class ProductModel extends RelationModel{
    protected $_link=array(
        'product_photo' => array(
            'mapping_type' => HAS_MANY,
            'mapping_key' => 'id',
            'foreign_key' => 'product_id',
            'class_name' => 'ProductPhoto',
        ),
        'product_price' => array(
            'mapping_type' => HAS_MANY,
            'mapping_key' => 'id',
            'foreign_key' => 'product_id',
            'class_name' => 'ProductPrice',
        ),
        'pro_class' => array(
            'mapping_type' => HAS_MANY,
            'mapping_key' => 'id',
            'foreign_key' => 'product_id',
            'class_name' => 'ProClass',
        ),
        'product_gifts' => array(
            'mapping_type' => HAS_MANY,
            'mapping_key' => 'id',
            'foreign_key' => 'pid',
            'class_name' => 'ProductGifts',
        ),
    );
} 