<?php

/**
 * 评论管理
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/10/15
 * Time: 下午3:22
 */
class CommentAction extends CommonAction{

    /**
     *  商品评论管理
     */
    public function index(){

        $where = '';

        $commentM = new CommentNewModel();
        $count = $commentM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $commentM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

//        dump($list);echo$commentM->getLastSql();
//        var_dump($list);
        $this->assign('list', $list);

        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     *  审核评论评论管理
     */

    public function Auditing()
    {
        $opt_key = I('operation', NULL);
        $commentid = I('commentid', NULL);
        if($opt_key != NULL)
        {
            //$opt_key = $optdata['operation'];
            //$commentid = $optdata['commentid'];

            $commentM = new CommentNewModel();
            //
            if($opt_key == 'pass')
            {
                $commentM->where('id='.$commentid)->save(array('is_review'=>'1'));
            }
            elseif($opt_key == 'refuse')
            {
                $commentM->where('id='.$commentid)->save(array('is_review'=>'2'));
            }
            elseif($opt_key == 'delete')
            {
                $commentM->where('id='.$commentid)->delete();
            }
            elseif($opt_key == 'recomment')
            {
                $commentM->where('id='.$commentid)->save(array('recommend'=>'1'));
            }
        }
    }

    public function tml()
    {
        $where = '';

        $comment_tmlM = M('comment_tml');
        $count = $comment_tmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $comment_tmlM->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display('tml');
    }

    public function addtml()
    {
        $this->display("tmladd");
    }

    public function edittml()
    {
        $id = I('id', 0);
        $areaM = M('comment_tml');
        $item = $areaM->where('id =' . $id)->find();

        $this->assign('item', $item);
        $this->display("tmledit");
    }

    public function savetml(){
        $id = I('id', 0);
        $order_id=I('order_id',0);
        $uid = I('uid','0');
        $content = I('content',0);
        $star = I('star',0);

        $comment_tmlM = M('comment_tml');

        $data = array();
        $data['order_id']=$order_id;
        $data['uid']=$uid;
        $data['content']=$content;
        $data['star']=$star;

        if($id != 0)
        {
            $res = $comment_tmlM->where('id = ' . $id)->save($data);
            //echo $areaM->getLastSql();
            if($res > 0)
                echo '更新成功';
            else
                echo '更新失败';
        }else
        {
            $insert_id =$comment_tmlM->add($data);
            if($insert_id != 0)
                echo '新增成功';
            else
                echo '插入失败';
        }

    }

    public function deltml(){
        $id = I('id', 0);
        if($id > 0){
            $comment_tmlM = M('comment_tml');
            $res = $comment_tmlM->where('id = ' . $id)->delete();

            if($res > 0)
                echo '删除成功';
            else
                echo '删除失败';
        }

    }

    //评价商品
    public function commentproduct()
    {
        $this->display("commentproduct");
    }

    public function savecommentproduct()
    {
        $product_id = I('product_id', 0);
        $comment_flag=I('comment_flag',0);
        $comment_num=I('comment_num',1);
        $comment_tml_id=I('comment_tml_id',0);

        $comment_tmlM = M('comment_tml');
        $comment_newM = M('comment_new');

        if($comment_flag == 0)
        {
            if($comment_tml_id == 0)
            {
                echo '操作失败';
                return;
            }

            $where = 'id='.$comment_tml_id;
            $list = $comment_tmlM->where($where)->select();

            $data = array();
            $data['order_id']=$list[0]['order_id'];
            $data['uid']=$list[0]['uid'];
            $data['content']=$list[0]['content'];
            $data['star']=$list[0]['star'];

            //不用管的数据
            $data['product_id']= $product_id;
            $data['comment_id']=0;
            $data['user_name']=' ';
            $data['time']=date("Y-m-d h:i:s");
            $data['is_review']=1;
            $data['show'] = 1;
            $data['review_time']="0000-00-00 00:00:00";
            $data['score']=0;
            $data['repay']=' ';
            $data['repay_time']="0000-00-00 00:00:00";
            $data['tag']=" ";

            $insert_id =$comment_newM->add($data);
            if($insert_id != 0)
                echo '新增成功';
            else
                echo '插入失败';
        }
        else
        {
            $where = '';

            $list = $comment_tmlM->where($where)->limit(0 . ',' . 10000)->select();
            $count = count($list);
            $rannumarray = array();
            for($inum=0;$inum<$comment_num;$inum++)
            {
                $randnum = rand(0,$count);
                if(!in_array($randnum,$rannumarray))
                    $rannumarray[] = $randnum;
            }

            $getnum=count($rannumarray);

            for($iget=0;$iget<$getnum;$iget++)
            {
                $index = $rannumarray[$iget];
                $item = $list[$index];

                $data = array();
                //读取评论模板数据
                $data['order_id']=$item['order_id'];
                $data['uid']=$item['uid'];
                $data['content']=$item['content'];
                $data['star']=$item['star'];

                //不用管的数据
                $data['product_id']= $product_id;
                $data['comment_id']=0;
                $data['user_name']=' ';
                $data['time']=date("Y-m-d h:i:s");
                $data['is_review']=1;
                $data['show'] = 1;
                $data['review_time']="0000-00-00 00:00:00";
                $data['score']=0;
                $data['repay']=' ';
                $data['repay_time']="0000-00-00 00:00:00";
                $data['tag']=" ";

                $insert_id =$comment_newM->add($data);
                if($insert_id != 0)
                    echo '新增成功'.$insert_id;
                else
                    echo '插入失败';
            }
        }
    }

}