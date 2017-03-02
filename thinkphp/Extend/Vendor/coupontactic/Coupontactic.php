<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/10
 * Time: 下午2:48
 */

/**
 * Class CouponTactic
 *  掉券策略抽象类
 */
abstract class  Coupontactic {

    abstract function setting();

    abstract function check($params);


}