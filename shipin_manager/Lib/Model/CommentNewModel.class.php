<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/9/10
 * Time: 下午12:15
 */
class CommentNewModel extends RelationModel{

    protected $_link=array(
        'Product'=>array(
            'mapping_type'  =>HAS_ONE,
            //当前类的外键，默认为主键
            'mapping_key' => 'product_id',
            'foreign_key'   =>'id',
            'class_name' => 'Product',
            'as_fields' => 'product_name,thum_photo',
        ) ,
        'User' => array(
            'mapping_type' => HAS_ONE,
            'mapping_key' => 'uid',
            'foreign_key' => 'id',
            'class_name' => 'User',
            'as_fields' => 'username,user_head',
        ),
    );

}