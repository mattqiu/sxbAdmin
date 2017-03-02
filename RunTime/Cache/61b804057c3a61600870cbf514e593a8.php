<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="select_all">
    <td class="id_order_name" style="text-align:left;text-indent:3px;">
        <input type="checkbox" class="checkOrder" value="<?php echo ($item["id"]); ?>"
                <?php if($item["jd_can_shipping"] != 2): ?>disabled<?php endif; ?>
                />&nbsp;<?php echo ($item["id"]); ?></td>
    <td>订:<?php echo ($item["order_name"]); ?> <br/>团:<?php echo ($item["groupbuy_order_name"]); ?></td>
    <td><?php echo ($item["rec_name"]); ?> <br/> <?php echo ($item["rec_mobile"]); ?></td>
    <td><?php echo ($item["product_name"]); ?></td>
    <td><?php echo ($item["delivery_id"]); ?></td>
    <td><?php echo ($item["print_num"]); ?></td>
    <td><?php echo ($item["package_num"]); ?></td>
    <td><?php echo ($item["send_warehome_name"]); ?></td>
    <td style="padding:0;">
        <?php if($item["status"] == 1): ?><span class="order_status tack">取出</span>
            <?php elseif($item["status"] == 2): ?><span class="order_status sync">同步</span>
            <?php elseif($item["status"] == 4): ?><span class="order_status deliver">发货</span>
            <?php elseif($item["status"] == 5): ?><span class="order_status merger">合并</span>
            <?php elseif($nums == 1): ?><span class="order_status print">已打印</span>
            <?php elseif($nums == 2): ?><span class="order_status print">未打印</span>
            <?php elseif($item["status"] == 10): ?><span class="order_status abnormal click_abnormal">异常&nbsp;
                <a class="delete" oid="<?php echo ($item["id"]); ?>" href="javascript:;" >删除</a></span><?php endif; ?>
    </td>
    <td>
        <?php if($type == 3): echo ($item["last_print_time"]); ?>
            <?php elseif($type == 2): echo ($item["last_import_jd_time"]); ?>
            <?php else: echo ($item["add_time"]); endif; ?>
    </td>
</tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>