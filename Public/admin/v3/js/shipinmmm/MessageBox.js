var MessageBox = {
    show:function(){
        var mMessage = (typeof(arguments[0]) != 'undefined') ? arguments[0] : '恭喜您，商品已成功加入购物车';
        var autotime = (typeof(arguments[1]) != 'undefined') ? arguments[1] : 3500;
        var effect = (typeof(arguments[2]) != 'undefined') ? arguments[2] : 'scroll';
        var title = (typeof(arguments[3]) != 'undefined') ? arguments[3] : '操作成功！';

        var el = $('<div class="m-global-tips"><dl class="clearfix"><dt class="m-global-suctips"></dt><dd><p>'
            + title + '</p>'+mMessage+'</dd></dl></div>');

        $('body').append(el);
        switch(effect){
            case 'downslide' :
                el.addClass('m-ani-in').delay(autotime).show(200,function(){
                    var $this=$(this)
                    $this.removeClass('m-ani-in').addClass('m-ani-out').delay(1000).hide(0, function(){  $this.remove(); });
                });
                break;
            default:
              el.delay(autotime).fadeOut(200,function(){
                $(this).remove();
              });
              break;
        }

    },
    warning:function(){

    },
    notice:function(){

    },
    tips:function(){
        var mMessage = (typeof(arguments[0]) != 'undefined') ? arguments[0] : 'tips info';
        var autotime = (typeof(arguments[1]) != 'undefined') ? arguments[1] : 2500;
        var effect = (typeof(arguments[2]) != 'undefined') ? arguments[2] : 'scroll';

        var el = $('<div class="m-global-tips"><dl class="clearfix"><dt class="m-global-suctips icon-tishi"></dt><dd class="m-global-tips-dd"> <div class="v-outer"><div class="v-middle" style="height: 50px;">'
         +mMessage+'</div></div></dd></dl></div>');

        $('body').append(el);
        switch(effect){
            case 'downslide' :
                el.addClass('m-ani-in').delay(autotime).show(200,function(){
                    var $this=$(this)
                    $this.removeClass('m-ani-in').addClass('m-ani-out').delay(1000).hide(0, function(){  $this.remove(); });
                });
                break;
            default:
                el.delay(autotime).fadeOut(200,function(){
                    $(this).remove();
                });
                break;
        }
    },
    error:function(){
        var mMessage = (typeof(arguments[0]) != 'undefined') ? arguments[0] : '亲，您的商品没有成功加入购物车，刷新一下试试哦~';
        var confirmCallback = arguments[1];

        var mboxel = $('body').data('mbox:error');
        if (!$.isEmptyObject(mboxel)) {
            mboxel.remove();
        };

        var el = $('<div class="m-global-tips"><dl class="clearfix"><dt class="icon-tishi"></dt><dd><p>操作失败！</p>'+mMessage+'</dd></dl><div class="text-center m-global-btngroup"></div></div>');

        var confirmBtn = $('<button>',{
            'type':'button',
            'class':'btn btn-default confirm',
            'text':'确 定',
            'click':function(){
                el.fadeOut(200,function(){
                    $(this).remove();
                    if ($.isFunction(confirmCallback)) {
                        confirmCallback();
                    };
                    $('body').removeData('mbox:error');
                });
            }
        });

        el.find('.m-global-btngroup').append(confirmBtn);

        $('body').append(el);

        $('body').data('mbox:error',el);
    },
    errorFadeout:function(){
        var mMessage = (typeof(arguments[0]) != 'undefined') ? arguments[0] : '错误';

        var mboxel = $('body').data('mbox:errorFadeout');
        if (!$.isEmptyObject(mboxel)) {
            mboxel.remove();
        };

        var el = $('<div class="m-global-tips"><dl class="clearfix"><dt class="icon-tishi"></dt><dd><p>操作失败！</p>'+mMessage+'</dd></dl></div>');

        $('body').append(el);

        $('body').data('mbox:errorFadeout',el);

      el.delay(2000).fadeOut(200,function(){
        $(this).remove();
        $('body').removeData('mbox:errorFadeout');
      });
    },
    confirm:function(){
        var mMessage = (typeof(arguments[0]) != 'undefined') ? arguments[0] : '亲，您真的要删除吗~';
        var confirmCallback = arguments[1];
        var cancelCallback = arguments[2];

        var mboxel = $('body').data('mbox:confirm');
        if (!$.isEmptyObject(mboxel)) {
            mboxel.remove();
        };

        var el = $('<div class="m-global-tips spicon"><dl class="clearfix"><dt ></dt><dd><br/>'+mMessage+'</dd></dl><div class="text-center m-global-btngroup"></div></div>');

        var cancelBtn = $('<button>',{
            'type':'button',
            'class':'btn btn-default cancel',
            'text':'取 消',
            'click':function(){
                el.fadeOut(200,function(){
                    $(this).remove();
                    if ($.isFunction(cancelCallback)) {
                        cancelCallback();
                    };
                    $('body').removeData('mbox:confirm');
                });
            }
        });

        var confirmBtn = $('<button>',{
            'type':'button',
            'class':'btn btn-default confirm',
            'text':'确 定',
            'click':function(){
                el.fadeOut(200,function(){
                    $(this).remove();
                    if ($.isFunction(confirmCallback)) {
                        confirmCallback();
                    };
                    $('body').removeData('mbox:confirm');
                });
            }
        });

        el.find('.m-global-btngroup').append(confirmBtn);
        el.find('.m-global-btngroup').append(cancelBtn);

        $('body').append(el);

        $('body').data('mbox:confirm',el);
    },
    loading:function(){

        var mboxel = $('body').data('mbox:loading');
        if (!$.isEmptyObject(mboxel)) {
            mboxel.remove();
        };

        var el = $('<div class="m-component-loading"><span class="spicon icon-jiazai "></span></div>');

        $('body').append(el);

        $('body').data('mbox:loading',el);
    },
    unloading:function(){
        var mboxel = $('body').data('mbox:loading');
        if (!$.isEmptyObject(mboxel)) {
            mboxel.remove();
        };
    },

    //优惠券列表提示
    couponhintlist:function() {
        var list = arguments[0];
        //MessageBox.couponhint('买买买','团长专享','团长免单券','免费开团，可以选择任意商品，结算时使用本券免单','本券不成团不退，加油拼','任意商品');
        //var strlist = arrayToJson(list);
        //var strbase64list = btoa(strlist);//返回base64编码后的字符
        this.couponhint(list,0);

    },
    //优惠券提示
    couponhint:function(){
        /*var title = arguments[0];
        var userdes = arguments[1];
        var coupontitle = arguments[2];
        var coupontext = arguments[3];
        var coupondes = arguments[4];
        var couponusescope = arguments[5];
        */

        //var strbase64list = arguments[0];
        var index = arguments[1];
        //var strjson_list = atob(strbase64list);//返回base64解码后的字符
        //var json_list = eval(strjson_list);//
        var json_list = arguments[0];
        var showdata = json_list[index];

        var pagesize = json_list.length;//总共几张

        var title = '恭喜你'
        var userdes = "团长专享";//谁能使用
        var coupontitle = showdata['sms_send_showtext'];//优惠券标题
        var coupontext = showdata['description'];//功能说明
        var coupondes = "本券不成团不退，加油拼";
        var couponusescope = showdata['direction'];//使用范围

        if(showdata['use_target'] == 0)
        {
            userdes = "无限制";
        }

        var mboxel = $('body').data('mbox:couponhint');
        if (!$.isEmptyObject(mboxel)) {
            mboxel.remove();
        };

        var couponhintdiv = $('<div id="couponhintdiv" class="couponhint-div" >' +
            '<div class="m-couponhint-content-pos">' +
            '<div class="m-couponhint-content">' +
            '<div class="m-couponhint-content-in-pos">'+
                '<img class="m-couponhint-content-bg" src="/images/couponhint_bg.png" alt="">' +
                '<div class="m-couponhint-titlediv">' +
                    '<span class="m-couponhint-title">'+title+'</span>' +
                '</div>'    +
                '<div class="m-couponhint-coupondiv">' +
                    '<div class="m-couponhint-userdiv">' +
                        '<span class="m-couponhint-user">' + userdes + '</span>' +
                    '</div>' +
                    '<div class="m-couponhint-coupontitlediv">' +
                    '<span class="m-couponhint-coupontitle">' + coupontitle + '</span>' +
                    '</div>' +
                    '<div class="m-couponhint-coupontextdiv">' +
                    '<span class="m-couponhint-coupontext">' + coupontext + '</span>' +
                    '</div>' +
                    '<div class="m-couponhint-coupondesdiv">' +
                    '<span class="m-couponhint-coupondes">' + coupondes + '</span>' +
                    '</div>' +
                    '<div class="m-couponhint-couponusescopediv">' +
                    '<span class="m-couponhint-couponusescopelabel">使用范围：</span>'+'<span class="m-couponhint-couponusescope">' +couponusescope + '</span>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
                    '</div>');

        var closeBtn = $('<button>',{
            'type':'button',
            'class':'m-couponhint-colsebtn',
            'text':'',
            'click':function(){
                couponhintdiv.fadeOut(200,function(){
                    $(this).remove();
                    /*if ($.isFunction(cancelCallback)) {
                        cancelCallback();
                    };*/
                    $('body').removeData('mbox:couponhint');
                });
            }
        });

        var gotoOpenBtn = $('<button>',{
            'type':'button',
            'class':'m-couponhint-gotoOpenbtn',
            'text':'去开团',
            'click':function(){
                couponhintdiv.fadeOut(200,function(){
                    $(this).remove();
                    $('body').removeData('mbox:couponhint');
                    location.href = '/';
                });
            }
        });

        var gotoSeeBtn = $('<button>',{
            'type':'button',
            'class':'m-couponhint-gotoSeebtn',
            'text':'去查看',
            'click':function(){
                couponhintdiv.fadeOut(200,function(){
                    $(this).remove();
                    $('body').removeData('mbox:couponhint');
                    location.href = '/user/coupon';
                });
            }
        });


        couponhintdiv.find('.m-couponhint-content-in-pos').append(closeBtn);
        couponhintdiv.find('.m-couponhint-content-in-pos').append(gotoOpenBtn);
        couponhintdiv.find('.m-couponhint-content-in-pos').append(gotoSeeBtn);

        var preLeadBtn = $('<button>',{
            'type':'button',
            'class':'m-couponhint-preSeebtn',
            'text':'',
            'click':function(){
                couponhintdiv.fadeOut(200,function(){
                    if(index > 0)
                    {
                        MessageBox.couponhint(json_list,index-1);
                    }

                });
            }
        });

        var nextLeadBtn = $('<button>',{
            'type':'button',
            'class':'m-couponhint-nextSeebtn',
            'text':'',
            'click':function(){
                couponhintdiv.fadeOut(200,function(){
                    if(index < pagesize)
                    {
                        MessageBox.couponhint(json_list,index+1);
                    }
                });
            }
        });

        if(index > 0)
        {
            couponhintdiv.find('.m-couponhint-content-in-pos').append(preLeadBtn);
        }
        if(index < pagesize-1)
        {
            couponhintdiv.find('.m-couponhint-content-in-pos').append(nextLeadBtn);
        }


        $('body').append(couponhintdiv);
        $('body').data('mbox:couponhint',couponhintdiv);
    }

};