<?php if (!defined('THINK_PATH')) exit();?><div id="order_info" class="m">
    <div class="mt">
        <strong>订单信息</strong></div>
    <div class="mc">
        <!--顾客信息-->
        <dl class="fore">
            <dt>收货人信息</dt>
            <dd>
                <ul>
                    <li>收&nbsp;货&nbsp;人：<?php echo ($order_info["name"]); ?></li>
                    <li>地&nbsp;&nbsp;&nbsp;&nbsp;址：<?php echo ($order_info["address"]); ?></li>
                    <li>手机号码：<?php echo ($order_info["mobile"]); ?></li>
                </ul>
            </dd>
        </dl>

        <!--配送、支付方式-->
        <dl>
            <dt>支付及配送方式</dt>
            <dd>
                <ul>
                    <li>支付方式：<?php echo ($order_info["pay_name"]); ?></li>
                    <li>运&nbsp;&nbsp;&nbsp;&nbsp;费：¥<?php echo ($order_info["method_money"]); ?></li>
                    <li>送货日期：<?php echo ($order_info["shtime"]); ?></li>
                </ul>
            </dd>
        </dl>
        <!--备注-->

        <!--商品-->
        <dl>
            <dt>
                <span class="">商品清单</span>
            <div class=""></div>
            </dt>

            <dd class="">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        <th width="10%"> 商品编号 </th>
                        <th width="12%"> 商品图片 </th>
                        <th width="42%"> 商品名称 </th>
                        <th width="10%"> 价格 </th>
                        <th width="8%"> 积分数量 </th>
                        <th width="7%"> 商品数量 </th>
                        <th width="11%">
                            操作
                        </th>
                    </tr>
                    <?php if(is_array($order_info["order_product"])): foreach($order_info["order_product"] as $key=>$product): ?><tr>
                            <td><?php echo ($product["product_no"]); ?></td>
                            <td>
                                <div class="img-list">
                                    <a href="" target="_blank" class="img-box">
                                        <img width="50" height="50" title="<?php echo ($product["product_name"]); ?>" src="<?php echo ($img_site); echo ($product["thum_min_photo"]); ?>">
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="al fl">
                                    <a href="" target="_blank"><?php echo ($product["product_name"]); ?></a>
                                </div>
                                <div class="clr"></div>
                                <div class="fl" id=""></div>
                            </td>
                            <td><span class="ftx04"> ¥<?php echo ($product["price"]); ?></span></td>
                            <td>0</td>
                            <td><?php echo ($product["qty"]); ?></td>
                            <td>
                                <span class="" id="iwo1500758"><a href="" target="_blank">查看评价</a>|<a target="_blank" href="">晒单</a>
				  <br>
                  <a  target="_blank" href="">申请退换货</a>
				</span><a target="_blank" href="" class="btn-again">还要买</a>
                            </td>
                        </tr><?php endforeach; endif; ?>
                    </tbody></table>
            </dd>
        </dl>
	</div>
    <!--金额-->
    <div class="">
        <ul>
            <li><span>总商品金额：</span>¥<?php echo ($order_info["goods_money"]); ?></li>
            <li><span>- 返现：</span>¥0.00</li>
            <li><span>+ 运费：</span>¥<?php echo ($product["method_money"]); ?></li>
        </ul>
        <div class="">
            应付总额：<span class=""><b>¥<?php echo ($order_info["money"]); ?></b></span>
        </div>
    </div>
</div>







<!--侧边导航栏-->
<div class="subNavBar">
    <a href="#base_info">基本信息</a>
    <a href="#goods_info">购买商品</a>
    <a href="#privilege">优惠方案</a>
    <a href="#payment_and_refund">收退款记录</a>
    <a href="#send_and_return">收发货记录</a>
    <a href="#remark">订单备注</a>
    <a href="#order_log">订单日志</a>
</div>
<!--内容区-->
<div class="mainCont">
    <div class="baseInfo" id="base_info">
        <div class="orderPriceInfo">
            <h3>订单价格信息</h3>
            <table>
                <thead>
                <tr>
                    <th>商品总额</th>
                    <th>配送费用</th>
                    <th>使用优惠方案</th>
                    <th>优惠抵扣金额</th>
                    <th>订单总额</th>
                    <th>已支付金额</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo ($order_info["goods_money"]); ?></td>
                    <td><?php echo ($order_info["method_money"]); ?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo ($order_info["money"]); ?></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="orderOtherInfo">
            <h3>订单其它信息</h3>
            <table>
                <thead>
                <tr>
                    <th>配送方式</th>
                    <th>商品重量</th>
                    <th>支付方式</th>
                    <th>是否开票</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo ($order_info["pay_name"]); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="orderBuyerInfo">
            <h3>下单用户</h3>
            <table>
                <thead>
                <tr>
                    <th>用户名</th>
                    <th>姓名</th>
                    <th>电话</th>
                    <th>手机</th>
                    <th>地区</th>
                    <th>email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo ($order_info["username"]); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo ($order_info["email"]); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="orderConsigneeInfo">
            <h3>收货人</h3>
            <table>
                <thead>
                <tr>
                    <th>送货日期</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>电话</th>
                    <th>地区</th>
                    <th>地址</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo ($order_info["shtime"]); ?></td>
                    <td><?php echo ($order_info["name"]); ?></td>
                    <td><?php echo ($order_info["mobile"]); ?></td>
                    <td><?php echo ($order_info["telephone"]); ?></td>
                    <td><?php echo ($order_info["position"]); ?></td>
                    <td><?php echo ($order_info["address"]); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="goodsInfo" id="goods_info">
        <table>
            <thead>
            <tr>
                <th>货品名称</th>
                <th>货品编号</th>
                <th>已发货量</th>
                <th>单价</th>
                <th>数量</th>
                <th>小计</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($order_products)): foreach($order_products as $key=>$product): ?><tr>
                <td><?php echo ($product["product_name"]); ?></td>
                <td><?php echo ($product["product_no"]); ?></td>
                <td></td>
                <td><?php echo ($product["price"]); ?></td>
                <td><?php echo ($product["qty"]); ?></td>
                <td><?php echo ($product["total_money"]); ?></td>
            </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <!--优惠方案-->
    <div class="privilege" id="privilege">
        <table>
            <thead>
            <tr>
                <td>优惠方案</td>
                <td>优惠金额</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>

    <!--收退款信息-->
    <div class="paymentAndRefund" id="payment_and_refund">
        <h3>收退款单据记录</h3>
        <div class="paymentInfo">
                <h4>收款单据记录</h4>
            <table>
                <thead>
                <tr>
                    <th>单据日期</th>
                    <th>支付金额</th>
                    <th>支付方式</th>
                    <th>状态</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="refundInfo">
            <h4>退款单据记录</h4>
            <table>
                <thead>
                <tr>
                    <th>单据日期</th>
                    <th>退款金额</th>
                    <th>状态</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
    <!--收发货记录-->
    <div class="sendAndReturn" id="send_and_return">
        <h3>收发货记录</h3>
        <div class="sendGoodsInfo">
            <h4>发货单据列表</h4>
            <table>
                <thead>
                <tr>
                    <th>建立日期</th>
                    <th>捡货/发货单号</th>
                    <th>物流单号</th>
                    <th>收件人</th>
                    <th>收件人电话</th>
                    <th>配送方式</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="returnGoodsInfo">
            <h4>退货单据列表</h4>
            <table>
                <thead>
                <tr>
                    <th>建立日期</th>
                    <th>退货单号</th>
                    <th>物流单号</th>
                    <th>退货人</th>
                    <th>退货人电话</th>
                    <th>配送方式</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="remark" id="remark">
        <h3>订单备注</h3>


    </div>

    <div class="orderLog" id="order_log">
        <h3>订单日志</h3>
        <table>
            <thead>
            <tr>
                <th>序号</th>
                <th>时间</th>
                <th>操作人</th>
                <th>行为</th>
                <th>结果</th>
                <th>备注</th>
            </tr>
            </thead>
        </table>
    </div>
</div>