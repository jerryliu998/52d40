<?php
/**
 * 销售管理
 * @author 齐迹  email:smpss2012@gmail.com
 *
 */
class c_sales extends base_c {
	function __construct($inPath) {
		parent::__construct ();
		if (self::isLogin () === false) {
			$this->ShowMsg ( "请先登录！", $this->createUrl ( "/main/index" ) );
		}
		if (self::checkRights ( $inPath ) === false) {
			//$this->ShowMsg("您无权操作！",$this->createUrl("/system/index"));
		}
		$this->params ['inpath'] = $inPath;
		$this->params ['head_title'] = "销售管理-" . $this->params ['head_title'];
	}

    //总订单列表
	function pageindex($inPath) {
		$url = $this->getUrlParams ( $inPath );
		$page = $url ['page'] ? ( int ) $url ['page'] : 1;
		$ymd = date ( "Y-m-d", time () );
		$condi = '';
        $status = -1;
		if ($_POST) {
			$key = base_Utils::getStr ( $_POST ['key'] );
			$stime = base_Utils::getStr ( $_POST ['stime'] );
			$etime = base_Utils::getStr ( $_POST ['etime'] );
            $status = base_Utils::getStr ( $_POST ['status'] );

			if ($key) {
				$condi = "order_id ='{$key}' or goods_name like '%{$key}%' or realname like '%{$key}%' or membercardid ='{$key}'";
			}
			if ($stime) {
				$etime = $etime ? $etime : $ymd;
				$condi = $condi ? $condi . " and" : "";
				$condi .= " dateymd between '{$stime}' and '{$etime}'";
			}
            if (intval($status)>=0){
                $condi = $condi ? $condi . " and" : "";
                $condi .= " status = ".$status;
            }
        }
		$saleObj = new m_sales ();
		$saleObj->setCount ( true );
		$saleObj->setPage ( $page );
		$saleObj->setLimit ( base_Constant::PAGE_SIZE );
		$rs = $saleObj->select ( $condi, "", "", "order by sid desc" );

        $result = array();
        $order_status_arr = base_Utils::getOrderStatus();

        if (!empty($rs->items)){
            foreach ($rs->items as $item) {
                $item['status_text'] = $order_status_arr[$item['status']];
                $result[] = $item;
            }
        }

        $this->params ['sales'] = $result;
		$this->params ['key'] = $key;
		$this->params ['stime'] = $stime;
		$this->params ['etime'] = $etime;
		$this->params ['pagebar'] = $this->PageBar ( $rs->totalSize, base_Constant::PAGE_SIZE, $page, $inPath );
        $this->params ['order_status'] = base_Utils::getOrderStatus();
        $this->params ['status'] = $status;

        return $this->render ( 'sales/index.html', $this->params );
	}

    //预约订单列表
    function pagebooklist($inPath) {
        $url = $this->getUrlParams ( $inPath );
        $page = $url ['page'] ? ( int ) $url ['page'] : 1;
        $ymd = date ( "Y-m-d", time () );
        $condi = 'order_type = 1';
        $status = -1;
        if ($_POST) {
            $key = base_Utils::getStr ( $_POST ['key'] );
            $stime = base_Utils::getStr ( $_POST ['stime'] );
            $etime = base_Utils::getStr ( $_POST ['etime'] );
            $status = base_Utils::getStr ( $_POST ['status'] );

            if ($key) {
                $condi = "order_id ='{$key}' or goods_name like '%{$key}%' or realname like '%{$key}%' or membercardid ='{$key}'";
            }
            if ($stime) {
                $etime = $etime ? $etime : $ymd;
                $condi = $condi ? $condi . " and" : "";
                $condi .= " dateymd between '{$stime}' and '{$etime}'";
            }
            if (intval($status)>=0){
                $condi = $condi ? $condi . " and" : "";
                $condi .= " status = ".$status;
            }
        }
        $saleObj = new m_sales ();
        if ($url ['ac'] == "cancel") {
            if($url['sid'] && $url['orderid']){

                $sale_info = $saleObj->select ( "sid={$url['sid']} and order_id={$url['orderid']}" )->items;
                if (count($sale_info) != 1)
                    $this->ShowMsg ( "该订单不存在！" );

                if ($sale_info[0]['status'] == base_Constant::ORDER_STATUS_OK)
                    $this->ShowMsg ( "已完成的订单不能取消！" );

                $status = base_Constant::ORDER_STATUS_CANCEL;
                $ret = $saleObj->update ( "sid={$url['sid']} and order_id={$url['orderid']}", "status={$status}" );
            }
            else
                $this->ShowMsg("缺少参数！");

            $this->ShowMsg ( "操作成功！", $this->createUrl ( "/sales/booklist" ), 1, 1 );
        }

        if ($url ['ac'] == "sendcode") {
            if($url['sid'] && $url['orderid']){
                $sale_info = $saleObj->select ( "sid={$url['sid']} and order_id={$url['orderid']}" )->items;
                if (count($sale_info) != 1)
                    $this->ShowMsg ( "该订单不存在！" );

                if ($sale_info[0]['order_type'] == base_Constant::ORDER_TYPE_BOOK){
                    $msg_content = "感谢订购".$sale_info[0]['goods_name'].",您的验证码是".$sale_info[0]['verify_code'];
                    base_Utils::sendMsg($sale_info[0]['membercardid'],$msg_content);
                }
            }
            else
                $this->ShowMsg("缺少参数！");

            $this->ShowMsg ( "发送成功！", $this->createUrl ( "/sales/booklist" ), 1, 1 );
        }

        $saleObj->setCount ( true );
        $saleObj->setPage ( $page );
        $saleObj->setLimit ( base_Constant::PAGE_SIZE );
        $rs = $saleObj->select ( $condi, "", "", "order by sid desc" );

        $result = array();
        $order_status_arr = base_Utils::getOrderStatus();

        if (!empty($rs->items)){
            foreach ($rs->items as $item) {
                $item['status_text'] = $order_status_arr[$item['status']];
                $result[] = $item;
            }
        }

        $this->params ['sales'] = $result;
        $this->params ['key'] = $key;
        $this->params ['stime'] = $stime;
        $this->params ['etime'] = $etime;
        $this->params ['pagebar'] = $this->PageBar ( $rs->totalSize, base_Constant::PAGE_SIZE, $page, $inPath );
        $this->params ['order_status'] = base_Utils::getOrderStatus();
        $this->params ['status'] = $status;
        return $this->render ( 'sales/booklist.html', $this->params );

    }

    //商品订单列表
    function pagegoodslist($inPath) {
        $url = $this->getUrlParams ( $inPath );
        $page = $url ['page'] ? ( int ) $url ['page'] : 1;
        $ymd = date ( "Y-m-d", time () );
        $condi = 'order_type = 2';
        $status = -1;
        if ($_POST) {
            $key = base_Utils::getStr ( $_POST ['key'] );
            $stime = base_Utils::getStr ( $_POST ['stime'] );
            $etime = base_Utils::getStr ( $_POST ['etime'] );
            $status = base_Utils::getStr ( $_POST ['status'] );

            if ($key) {
                $condi = "order_id ='{$key}' or goods_name like '%{$key}%' or realname like '%{$key}%' or membercardid ='{$key}'";
            }
            if ($stime) {
                $etime = $etime ? $etime : $ymd;
                $condi = $condi ? $condi . " and" : "";
                $condi .= " dateymd between '{$stime}' and '{$etime}'";
            }
            if (intval($status)>=0){
                $condi = $condi ? $condi . " and" : "";
                $condi .= " status = ".$status;
            }
        }
        $saleObj = new m_sales ();

        if ($url ['ac'] == "cancel") {
            if($url['sid'] && $url['orderid']){
                $sale_info = $saleObj->select ( "sid={$url['sid']} and order_id={$url['orderid']}" )->items;
                if (count($sale_info) != 1)
                    $this->ShowMsg ( "该订单不存在！" );

                if ($sale_info[0]['status'] == base_Constant::ORDER_STATUS_OK)
                    $this->ShowMsg ( "已完成的订单不能取消！" );

                $status = base_Constant::ORDER_STATUS_CANCEL;
                $ret = $saleObj->update ( "sid={$url['sid']} and order_id={$url['orderid']}", "status={$status}" );
            }
            else
                $this->ShowMsg("缺少参数！");

            $this->ShowMsg ( "操作成功！", $this->createUrl ( "/sales/goodslist" ), 1, 1 );
        }

        $saleObj->setCount ( true );
        $saleObj->setPage ( $page );
        $saleObj->setLimit ( base_Constant::PAGE_SIZE );
        $rs = $saleObj->select ( $condi, "", "", "order by sid desc" );

        $result = array();
        $order_status_arr = base_Utils::getOrderStatus();

        if (!empty($rs->items)){
            foreach ($rs->items as $item) {
                $item['status_text'] = $order_status_arr[$item['status']];
                $result[] = $item;
            }
        }

        $this->params ['sales'] = $result;
        $this->params ['key'] = $key;
        $this->params ['stime'] = $stime;
        $this->params ['etime'] = $etime;
        $this->params ['pagebar'] = $this->PageBar ( $rs->totalSize, base_Constant::PAGE_SIZE, $page, $inPath );
        $this->params ['order_status'] = base_Utils::getOrderStatus();
        $this->params ['status'] = $status;
        return $this->render ( 'sales/goodslist.html', $this->params );
    }

    //废弃
	function pagesales($inPath) {
		$url = $this->getUrlParams ( $inPath );
		session_start ();
		$order_id = $_SESSION ['order_id'];
		$tempsales = new m_tempsales();
		if (! $order_id) {
			$order_id = date ( "mdHis", time () ) . base_Utils::random ( 4, 1 );
			$_SESSION ['order_id'] = $order_id;
		}else{
			$info = $tempsales->select("order_id='{$order_id}'")->items;
		}
		if ($url ['ac'] == "del") {
			if($order_id){
				if(!$tempsales->delOrder($order_id)){
					$this->ShowMsg("清空出错！".$tempsales->getError());
				}
			}
			$this->ShowMsg ( "操作成功！", $this->createUrl ( "/sales/sales" ), 1, 1 );
		}
		if ($_POST) {
			$goods_sn = base_Utils::getStr ( $_POST ['goods_sn'] );
			$num = ( float ) $_POST ['num'] ? ( float ) $_POST ['num'] : 1;
			$ishas = 0;
			if (is_array ( $info )) {
				foreach ( $info as $k => $v ) {
					if ($v ['goods_sn'] == $goods_sn) {
						$info [$k] ['num'] += $num;
						$ishas = 1;
						if ($info [$k] ['num'] > $v ['stock']) {
							$info [$k] ['num'] -= $num;
							$this->ShowMsg ( "该商品库存不足！", $this->createUrl ( "/sales/sales" ) );
						}
						$data['order_id'] = $order_id;
						$data['goods_id'] = $v['goods_id'];
						$data['num'] = $info [$k] ['num'];
						if(!$tempsales->updateOrder($data)){
							$this->ShowMsg("插入订单失败！");
						}
					}
				}
			}
			if (! $ishas) {
				$goodsObj = new m_goods ();
				$goods = $goodsObj->getSalePrice ( $goods_sn );
				if (! $goods)
					$this->ShowMsg ( "商品信息不存在", $this->createUrl ( "/sales/sales" ), 1 );
				if ($num > $goods ['stock'])
					$this->ShowMsg ( "该商品库存不足！", $this->createUrl ( "/sales/sales" ) );
				$goods ['num'] = $num;
				if(!$tempsales->insertOrder($goods,$order_id)){
					$this->ShowMsg("插入订单失败！".$tempsales->getError());
				}
			}
			//$_SESSION ['goodsInfo'] = $info;
			$this->redirect ( $this->createUrl ( "/sales/sales" ) );
		}
		$total = $discount = 0;
		if (is_array ( $info )) {
			foreach ( $info as $v ) {
				$total += $v ['num'] * $v ['out_price'];
				$discount += $v ['num'] * $v ['p_discount'];
			}
		}
		$this->params ['total'] = $total;
		$this->params ['order_id'] = $order_id;
		$this->params ['discount'] = $discount;
		$this->params ['info'] = $info;
		//print_r($info);
		return $this->render ( 'sales/sales.html', $this->params );
	}

    //预约订单
    function pagebook($inPath) {

        $url = $this->getUrlParams ( $inPath );
        session_start ();
        $order_id = $_SESSION ['order_id'];
        $tempsales = new m_tempsales();
        if (! $order_id) {
            $order_id = date ( "mdHis", time () ) . base_Utils::random ( 4, 1 );
            $_SESSION ['order_id'] = $order_id;
        }else{
            $info = $tempsales->select("order_id='{$order_id}'")->items;
        }

        //获取预约商品
        $goodsObj = new m_goods ();
        $goods_type = 1;
        $book_goods_list = $goodsObj->select("goods_type='{$goods_type}'")->items;

        if ($url ['ac'] == "del") {
            if($order_id){
                if(!$tempsales->delOrder($order_id)){
                    $this->ShowMsg("清空出错！".$tempsales->getError());
                }
            }
            $this->ShowMsg ( "操作成功！", $this->createUrl ( "/sales/book" ), 1, 1 );
        }
        if ($_POST) {
            $goods_sn = base_Utils::getStr ( $_POST ['goods_sn'] );
            $num = ( float ) $_POST ['num'] ? ( float ) $_POST ['num'] : 1;
            $ishas = 0;
            if (is_array ( $info )) {
                foreach ( $info as $k => $v ) {
                    if ($v ['goods_sn'] == $goods_sn) {
                        $info [$k] ['num'] += $num;
                        $ishas = 1;
                        if ($info [$k] ['num'] > $v ['stock']) {
                            $info [$k] ['num'] -= $num;
                            $this->ShowMsg ( "该商品库存不足！", $this->createUrl ( "/sales/book" ) );
                        }
                        $data['order_id'] = $order_id;
                        $data['goods_id'] = $v['goods_id'];
                        $data['num'] = $info [$k] ['num'];
                        if(!$tempsales->updateOrder($data)){
                            $this->ShowMsg("插入订单失败！");
                        }
                    }
                }
            }
            if (! $ishas) {
                $goodsObj = new m_goods ();
                $goods = $goodsObj->getSalePrice ( $goods_sn );
                if (! $goods)
                    $this->ShowMsg ( "商品信息不存在", $this->createUrl ( "/sales/book" ), 1 );
                if ($num > $goods ['stock'])
                    $this->ShowMsg ( "该商品库存不足！", $this->createUrl ( "/sales/book" ) );
                $goods ['num'] = $num;
                if(!$tempsales->insertOrder($goods,$order_id)){
                    $this->ShowMsg("插入订单失败！".$tempsales->getError());
                }
            }
            //$_SESSION ['goodsInfo'] = $info;
            $this->redirect ( $this->createUrl ( "/sales/book" ) );
        }
        $total = $discount = 0;
        if (is_array ( $info )) {
            foreach ( $info as $v ) {
                $total += $v ['num'] * $v ['out_price'];
                $discount += $v ['num'] * $v ['p_discount'];
            }
        }
        $this->params ['total'] = $total;
        $this->params ['order_id'] = $order_id;
        $this->params ['discount'] = $discount;
        $this->params ['info'] = $info;
        $this->params ['book_goods_list'] = $book_goods_list;
        //print_r($info);
        return $this->render ( 'sales/book.html', $this->params );
    }

    //编辑预约订单
    function pageeditbook($inPath) {

        $url = $this->getUrlParams ( $inPath );
        if(!$url['sid'] || !$url['orderid']){
            $this->ShowMsg ( "缺少参数！" );
        }

        $saleObj = new m_sales ();
        $sale_info = $saleObj->select ( "sid={$url['sid']} and order_id={$url['orderid']}" )->items;
        if (count($sale_info) != 1)
            $this->ShowMsg ( "该订单不存在！" );

        if ($_POST){
            //拼接额外信息
            $ext_detail = array();
            $ext_detail['child_name'] = $_POST['child_name'];
            $ext_detail['sex'] = $_POST['sex'];
            $ext_detail['age'] = $_POST['age'];
            $ext_detail['weight'] = $_POST['weight'];
            $ext_detail['height'] = $_POST['height'];
            $ext_detail['shoe_size'] = $_POST['shoe_size'];
            $ext_detail = json_encode($ext_detail,JSON_UNESCAPED_UNICODE);
            $remark = $_POST['remark'];

            $ret = $saleObj->update ( "sid={$url['sid']} and order_id='{$url['orderid']}'", "ext_detail='{$ext_detail}',remark='{$remark}'" );

            if ($ret>=0)
                $this->ShowMsg ( "操作成功！", $this->createUrl ( "/sales/booklist" ), 1, 1 );
            else
                $this->ShowMsg("预约订单编辑失败！");
        }

        $this->params ['sale_info'] = $sale_info[0];
        //获取额外信息
        $ext_detail = json_decode($sale_info[0]['ext_detail'],true);
        $this->params ['ext_detail'] = $ext_detail;

        return $this->render ( 'sales/editbook.html', $this->params );
    }

    //商品订单
    function pagegoods($inPath) {

        $url = $this->getUrlParams ( $inPath );
        session_start ();
        $order_id = $_SESSION ['order_id'];
        $tempsales = new m_tempsales();
        if (! $order_id) {
            $order_id = date ( "mdHis", time () ) . base_Utils::random ( 4, 1 );
            $_SESSION ['order_id'] = $order_id;
        }else{
            $info = $tempsales->select("order_id='{$order_id}'")->items;
        }

        //获取预约商品
        $goodsObj = new m_goods ();
        $goods_type = 2;
        $book_goods_list = $goodsObj->select("goods_type='{$goods_type}'")->items;

        if ($url ['ac'] == "del") {
            if($order_id){
                if(!$tempsales->delOrder($order_id)){
                    $this->ShowMsg("清空出错！".$tempsales->getError());
                }
            }
            $this->ShowMsg ( "操作成功！", $this->createUrl ( "/sales/goods" ), 1, 1 );
        }

        if ($_POST) {
            $goods_sn = base_Utils::getStr ( $_POST ['goods_sn'] );
            $num = ( float ) $_POST ['num'] ? ( float ) $_POST ['num'] : 1;
            $ishas = 0;
            if (is_array ( $info )) {
                foreach ( $info as $k => $v ) {
                    if ($v ['goods_sn'] == $goods_sn) {
                        $info [$k] ['num'] += $num;
                        $ishas = 1;
                        if ($info [$k] ['num'] > $v ['stock']) {
                            $info [$k] ['num'] -= $num;
                            $this->ShowMsg ( "该商品库存不足！", $this->createUrl ( "/sales/goods" ) );
                        }
                        $data['order_id'] = $order_id;
                        $data['goods_id'] = $v['goods_id'];
                        $data['num'] = $info [$k] ['num'];
                        if(!$tempsales->updateOrder($data)){
                            $this->ShowMsg("插入订单失败！");
                        }
                    }
                }
            }
            if (! $ishas) {
                $goodsObj = new m_goods ();
                $goods = $goodsObj->getSalePrice ( $goods_sn );
                if (! $goods)
                    $this->ShowMsg ( "商品信息不存在", $this->createUrl ( "/sales/goods" ), 1 );
                if ($num > $goods ['stock'])
                    $this->ShowMsg ( "该商品库存不足！", $this->createUrl ( "/sales/goods" ) );
                $goods ['num'] = $num;
                if(!$tempsales->insertOrder($goods,$order_id)){
                    $this->ShowMsg("插入订单失败！".$tempsales->getError());
                }
            }
            //$_SESSION ['goodsInfo'] = $info;
            $this->redirect ( $this->createUrl ( "/sales/goods" ) );
        }
        $total = $discount = 0;
        if (is_array ( $info )) {
            foreach ( $info as $v ) {
                $total += $v ['num'] * $v ['out_price'];
                $discount += $v ['num'] * $v ['p_discount'];
            }
        }
        $this->params ['total'] = $total;
        $this->params ['order_id'] = $order_id;
        $this->params ['discount'] = $discount;
        $this->params ['info'] = $info;
        $this->params ['book_goods_list'] = $book_goods_list;
        //print_r($info);
        return $this->render ( 'sales/goods.html', $this->params );
    }

    //创建订单
	function pageOut($inPath) {
        $saleObj = new m_sales ();
        $sales = $mem_rs = array ();
        $purchaseObj = new m_purchase ();
        $url = $this->getUrlParams ( $inPath );

        $third_order_id = '0';
        $order_type = 0;
        $status = base_Constant::ORDER_STATUS_NEW;
        //预约订单
        if ($_POST['order_type'] == 1){
            if (!$_POST['third_order_id'])
                $this->ShowMsg("请输入第三方订单号！");

            $third_order_id = $_POST['third_order_id'];
            $order_type = 1;
            $temp_sales = $saleObj->select("third_order_id='{$third_order_id}'")->items;

            if (!empty($temp_sales))
                $this->ShowMsg("此订单已经录入！");

            //拼接额外信息
            $ext_detail = array();
            $ext_detail['child_name'] = $_POST['child_name'];
            $ext_detail['sex'] = $_POST['sex'];
            $ext_detail['age'] = $_POST['age'];
            $ext_detail['weight'] = $_POST['weight'];
            $ext_detail['height'] = $_POST['height'];
            $ext_detail['shoe_size'] = $_POST['shoe_size'];

            $ext_detail = json_encode($ext_detail,JSON_UNESCAPED_UNICODE);

            $remark = $_POST['remark'];
            $status = base_Constant::ORDER_STATUS_PAY;
        }
        //商品订单
        else if ($_POST['order_type'] == 2){
            $order_type = 2;
            $status = base_Constant::ORDER_STATUS_OK;
        }
        //其他订单
        else{
            if ($url['ac']!='p' && $url['ac']!='verify')
                $this->ShowMsg("订单类型出错！");
        }

		$order_id = $url['oid'];
		session_start ();
		$tempsales = new m_tempsales();
		$info = $tempsales->select("order_id='{$order_id}'")->items;
		//$info = $_SESSION ['goodsInfo'];
		if (is_array ( $info )) {
			$url['ac']='';
			$dateline = time();
			$goodsObj = new m_goods ();
			$mobile = base_Utils::getStr ( $_POST ['mobile'] );
			if ($mobile) {
				$memberObj = new m_member ();

                //判断用户是否存在
                $mem_info = $memberObj->select("mobile='{$mobile}'")->items;
                if (empty($mem_info)){
                    //不存在创建用户
                    $data = array();
                    $data['realname'] = $mobile;
                    $data['membercardid'] = $mobile;
                    $data['mobile'] = $mobile;
                    $insert_id = $memberObj->create($data);
                    $mem_info = $memberObj->select("mid='{$insert_id}'")->items;
                }

                $mem_rs = $memberObj->getMemberPrice ( $mem_info[0]['membercardid'] );
				if (! $mem_rs ['mid'])
					$this->ShowMsg ( "会员卡不存在！" );
				$sales ['mid'] = $mem_rs ['mid'];
				$sales ['membercardid'] = $mem_rs ['membercardid'];
				$sales ['realname'] = $mem_rs ['realname'];
			}
			//$order_id = date ( "mdHis", time () ) . base_Utils::random ( 4, 1 );
			$mem_amount = 0;
			$pro_amount = 0;
            $out_amount = 0;
			foreach ( $info as $k => $v ) {
				$out_amount += sprintf ( "%01.2f", $v ['out_price'] * $v ['num'] ); //总价
				$pro_amount += sprintf ( "%01.2f", $v ['p_discount'] * $v ['num'] ); //促销优惠的总价
				$sales ['order_id'] = $order_id;
				$sales ['goods_id'] = $v ['goods_id'];
				$sales ['cat_id'] = $v ['cat_id'];
				$sales ['goods_sn'] = $v ['goods_sn'];
				$sales ['goods_name'] = $v ['goods_name'];
				$sales ['num'] = $v ['num'];
				$sales ['out_price'] = $v ['out_price'];
				$sales ['in_price'] = $goodsObj->getAvgPrice ( $v ['goods_id'] );
				$sales ['p_discount'] = $v ['p_discount']; //促销优惠的金额
				$sales ['price'] = $sales ['out_price'] - $sales ['p_discount'];
				if ($v ['ismemberprice'] == 1 and $mem_rs ['mid']) {
					$sales ['m_discount'] = ($v ['out_price'] - $v ['p_discount']) * (100 - $mem_rs ['discount']) / 100; //会员+促销优惠
					$sales ['m_discount'] = sprintf ( "%01.2f", $sales ['m_discount'] );
					$sales ['price'] = $sales ['out_price'] - $sales ['m_discount'];
					$mem_amount += sprintf ( "%01.2f", $sales ['m_discount'] * $v ['num'] ); //会员+促销总价
				}
				$sales ['dateymd'] = date ( "Y-m-d", time () );
				$sales ['dateline'] = time ();
                $sales ['third_order_id'] = $third_order_id;
                $sales ['order_type'] = $order_type;
                $sales ['ext_detail'] = $ext_detail;
                $sales ['remark'] = $remark;
                $sales ['status'] = $status;

                //生成验证码
                $verify_code = rand(100000,999999);
                while(true){
                    $verify_sales = $saleObj->select("verify_code='{$verify_code}'")->items;
                    if (empty($verify_sales))
                        break;
                    $verify_code = rand(100000,999999);
                }
                $sales ['verify_code'] = $verify_code;

                if (! $saleObj->insert ( $sales )) {
					$this->ShowMsg ( "添加销售记录错误！" . $saleObj->getError () );
				}
				$purchaseObj->outStock ( $sales ['goods_id'], $v ['num'], sprintf ( "%01.2f", $sales ['price'] * $v ['num'] ) );

                //给用户发送短信
                if ($order_type == base_Constant::ORDER_TYPE_BOOK){
                    $msg_content = "感谢订购".$v ['goods_name'].",您的验证码是".$sales ['verify_code'];
                    base_Utils::sendMsg($mobile,$msg_content);
                }
            }
			//计算应收金额
			$real_amount = $out_amount-$mem_amount-$pro_amount;
			if ($sales ['mid']) {
				$memberObj->setCredit ( $sales ['mid'] );
			}
			$tempsales->delOrder($order_id);//清除临时销售记录
		}
		$goods = $saleObj->select ( "order_id={$order_id}" )->items;

		if($url['ac']=='p' || $url['ac']=='verify'){//独立打印
			if(!is_array($goods)){
				$this->ShowMsg ( "订单中没有任何商品！" );
			}
			foreach ( $goods as $k => $v ) {
				$out_amount += sprintf ( "%01.2f", $v ['out_price'] * $v ['num'] ); //应收金额
				$pro_amount += sprintf ( "%01.2f", $v ['p_discount'] * $v ['num'] ); //促销优惠的总价
				$mem_amount += sprintf ( "%01.2f", $v ['m_discount'] * $v ['num'] ); //会员优惠的总价
				$real_amount += sprintf ( "%01.2f", $v ['price'] * $v ['num'] ); //实收金额 减去会员优惠和促销优惠
				$dateline = $v['dateline'];
			}
		}
		$this->params ['goods'] = $goods;
		$this->params ['order_id'] = $order_id;
		$this->params ['out_amount'] = $out_amount;
		$this->params ['real_amount'] = $real_amount;
		$this->params ['pro_amount'] = $pro_amount;
		$this->params ['mem_amount'] = $mem_amount;
		$this->params ['dateline'] = $dateline;
		$_SESSION ['order_id'] = "";

        if ($url['ac']=='verify'){
            $this->params ['membercardid'] = $url['membercardid'];
            $this->params ['verifycode'] = $url['verifycode'];
            return $this->render ( 'sales/verifyconfirm.html', $this->params );
        }
        else
            return $this->render ( 'sales/out.html', $this->params );
	}
	/**
	 * 打印小票
	 * @param array $inPath
	 */
	function pageprint($inPath){
		$url = $this->getUrlParams ( $inPath );
		$page = $url ['page'] ? ( int ) $url ['page'] : 1;
		$ymd = date ( "Y-m-d", time () );
		$condi = '';
		if ($_POST) {
			$key = base_Utils::getStr ( $_POST ['key'] );
			$stime = base_Utils::getStr ( $_POST ['stime'] );
			$etime = base_Utils::getStr ( $_POST ['etime'] );
			if ($key) {
				$condi = "order_id ='{$key}' or goods_name like '%{$key}%' or realname like '%{$key}%' or membercardid ='{$key}'";
			}
			if ($stime) {
				$etime = $etime ? $etime : $ymd;
				$condi = $condi ? $condi . " and" : "";
				$condi .= " dateymd between '{$stime}' and '{$etime}'";
			}
		}
		$saleObj = new m_sales ();
		$saleObj->setCount ( true );
		$saleObj->setPage ( $page );
		$saleObj->setLimit ( base_Constant::PAGE_SIZE );
		$rs = $saleObj->select ( $condi, "order_id,sum(price*num) as allprice,dateymd,dateline,sum(p_discount+m_discount) as discount,sum(refund_amount) as refund", "group by order_id", "order by sid desc" );
		$this->params ['sales'] = $rs->items;
		$this->params ['key'] = $key;
		$this->params ['stime'] = $stime;
		$this->params ['etime'] = $etime;
		$this->params ['pagebar'] = $this->PageBar ( $rs->totalSize, base_Constant::PAGE_SIZE, $page, $inPath );
		return $this->render ( 'sales/print.html', $this->params );
	}

    /*
     * 订单核销验证
     */
    function pageverify(){
        $condi = '';
        if ($_POST) {
            $membercardid = base_Utils::getStr ( $_POST ['membercardid'] );
            $verify_code = base_Utils::getStr ( $_POST ['verify_code'] );

            $saleObj = new m_sales ();
            $sale_info = $saleObj->select ( "membercardid={$membercardid} and verify_code={$verify_code}" )->items;
            if (count($sale_info) != 1)
                $this->ShowMsg ( "该订单不存在！" );

            if ($sale_info[0]['status'] != base_Constant::ORDER_STATUS_PAY)
                $this->ShowMsg ( "该订单已经核销！" );


            $this->redirect ( $this->createUrl ( "/sales/out",array("ac"=>"verify","oid"=>$sale_info[0]['order_id'],"membercardid"=>$sale_info[0]['membercardid'],"verifycode"=>$sale_info[0]['verify_code']) ) );


        }
        return $this->render ( 'sales/verify.html', $this->params );
    }

    /*
     * 订单核销
     */
    function pageverifyconfirm($inPath){
        date_default_timezone_set('Asia/Shanghai');

        $url = $this->getUrlParams ( $inPath );

        if($url['membercardid'] && $url['verifycode']){
            $membercardid = base_Utils::getStr ( $url ['membercardid'] );
            $verify_code = base_Utils::getStr ( $url ['verifycode'] );

            $saleObj = new m_sales ();
            $sale_info = $saleObj->select ( "membercardid={$membercardid} and verify_code={$verify_code}" )->items;
            if (count($sale_info) != 1)
                $this->ShowMsg ( "该订单不存在！" );

            if ($sale_info[0]['status'] != base_Constant::ORDER_STATUS_PAY)
                $this->ShowMsg ( "该订单已经核销！" );


            $status = base_Constant::ORDER_STATUS_OK;
            $ret = $saleObj->update ( "membercardid={$membercardid} and verify_code={$verify_code}", "status={$status}" );

            $msg_content = "您订购的".$sale_info[0]['goods_name']."于".date('Y-m-d H:i:s',time())."核销成功";
            base_Utils::sendMsg($sale_info[0]['membercardid'],$msg_content);

            $this->ShowMsg ( "核销成功！", $this->createUrl ( "/sales/booklist" ), 1, 1 );
        }
        else{
            $this->ShowMsg ( "缺少参数！" );
        }
    }

	/**
	 * 处理退货
	 * @param array $inPath
	 */
	function pagereturn($inPath) {
		$url = $this->getUrlParams ( $inPath );
		if ($_POST) {
			$order_id = base_Utils::getStr ( $_POST ['order_id'] );
			$salesObj = new m_sales ();
			$this->params ['order_id'] = $order_id;
			if ($_POST ['ac'] == 'del') {
				$sidArr = ( array ) $_POST ['sid'];
				$numArr = ( array ) $_POST ['num'];
				$returnArr = array ();
				$i = 0;
				if ($sidArr) {
					foreach ( $sidArr as $k => $v ) {
						$rs = $salesObj->selectOne ( "sid={$v} and order_id={$order_id} and refund_type=0", "num,goods_id,goods_name,price,mid" ); //退过款的商品不能够二次退款
						if (! $rs)
							$this->ShowMsg ( "该订单中没有该商品！" );
						$mid = $rs ['mid'];
						if ($numArr [$k] > 0 and $numArr [$k] <= $rs ['num']) {
							$returnArr [$i] ['sid'] = ( int ) $v;
							$returnArr [$i] ['goods_id'] = $rs ['goods_id'];
							$returnArr [$i] ['num'] = ( float ) $numArr [$k];
							$returnArr [$i] ['refund_type'] = 2;
							$returnArr [$i] ['refund_amount'] = sprintf ( "%01.2f", $rs ['price'] * $numArr [$k] );
							if ($numArr [$k] == $rs ['num']) {
								$returnArr [$i] ['refund_type'] = 1;
							}
							$i ++;
						} else {
							$this->ShowMsg ( "{$rs['goods_name']} 退货数量不正确" );
						}
					}
				}
				$purchaseObj = new m_purchase ();
				//退货操作 1修改库存 2 修改商品销售总价 3更新会员卡积分
				foreach ( $returnArr as $v ) {
					if (! $purchaseObj->backStock ( $v ['goods_id'], $v ['num'], $v ['refund_amount'] )) {
						$salesObj->update ( "order_id={$order_id} and goods_id = {$v['goods_id']}", "refund_type={$v['refund_type']},refund_amount={$v['refund_amount']},refund_num={$v['num']}" );
						$this->ShowMsg ( "商品{$v['goods_id']}退款出错" . $purchaseObj->getError () );
					}
				}
				if ($mid) {
					$memberObj = new m_member ();
					$memberObj->setCredit ( $mid );
				}
				$this->ShowMsg ( "退货成功！", $this->createUrl ( "/sales/return" ), 20, 1 );
			}
			$this->params ['list'] = $salesObj->select ( "order_id='{$order_id}'" )->items;
		}
		return $this->render ( 'sales/return.html', $this->params );
	}
}