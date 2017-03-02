<?php

require_once('tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class JdPrintPdf extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set the starting point for the page content
		$this->setPageMark();
		$this->SetFont('helvetica','', 15);

		// set cell padding
		$this->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		$this->setCellMargins(1, 1, 1, 1);

		// set color for background
		$this->SetFillColor(255, 255, 255);

		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$this->SetFont('sansfallback','', 10);
		// set some text for example
		$txt = 'Lorem';

//		MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
		/*设置线条的风格：
     Width：设置线条粗细
     Cap：设置线条的两端形状
     Join：设置线条连接的形状
     Dash：设置虚线模式
     Color：设置线条颜色，一般设置为黑色，如：array(0, 0, 0)。*/
		$this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'color' => array(0, 0,0)));

		/*画一条线：
        x1：线条起点x坐标
        y1：线条起点y坐标
        x2：线条终点x坐标
        y2：线条终点y坐标
        style：SetLineStyle的效果一样
        */
		//大横线
		$this->Line(7, 6, 104, 6, $style=array());
		$this->Line(7, 25, 104, 25, $style=array());
		$this->Line(7, 37, 104, 37, $style=array());
		$this->Line(7, 43, 104, 43, $style=array());
		$this->Line(7, 60, 104, 60, $style=array());

		//竖外框
		$this->Line(7, 6, 7, 60, $style=array());
		$this->Line(104, 6, 104, 60, $style=array());

		//中间短分隔线
		$this->Line(13, 37, 13, 60, $style=array());
		$this->Line(57, 25, 57, 43, $style=array());
		$this->Line(65, 37, 65, 60, $style=array());
		$this->Line(76, 43, 76, 60, $style=array());
		//中间短横线
		$this->Line(65, 52, 104, 52, $style=array());

		//下半个面单框
		//大横线2
		$this->Line(7, 66, 104, 66, $style=array());
		$this->Line(7, 73, 104, 73, $style=array());
		$this->Line(7, 88, 104, 88, $style=array());
		$this->Line(7, 96, 104, 96, $style=array());
		$this->Line(7, 103, 104, 103, $style=array());
		$this->Line(7, 110, 104, 110, $style=array());
		//竖外框
		$this->Line(7, 66, 7, 110, $style=array());
		$this->Line(104, 66, 104, 110, $style=array());
		//中间分隔竖线
		$this->Line(33, 88, 33, 96, $style=array());
		$this->Line(65, 73, 65, 110, $style=array());
		$this->Line(85, 88, 85, 96, $style=array());

		/*执行一个换行符，横坐标自动移动到左边距的距离，纵坐标换到下一行：
        H：设置下行跟上一行的距离，默认的话，高度为最后一个单元格的高度
        Cell：true，添加左或右或上的间距到横坐标。 */
		//       $pdf->Ln($h='', $cell=false);
		$today = date('Y-m-d', time());
		$this->SetFont('helvetica','', 9);
		$this->MultiCell(30, 6, '1.00   KG', 0, 'L', 0, 0, 82, 18, true);

		$this->SetFont('sansfallback','', 8);
		$this->MultiCell(50, 8, '始发地:', 0, 'L', 0, 1, 6, 23, true);
		$this->MultiCell(50, 8, '目的地:', 0, 'L', 0, 1, 56, 23, true);

		$this->MultiCell(5, 16, '客户信息', 0, 'C', 0, 1, 6, 43, true);

		$this->MultiCell(10, 8, '客户签字', 0, 'C', 0, 1, 65, 42, true);
		$this->MultiCell(10, 7, '应收金额', 0, 'C', 0, 1, 65, 51, true);
		$this->SetFont('sansfallback','', 12);
		$this->MultiCell(26, 7, '￥0.00元', 0, 'C', 0, 1, 75, 52, true);

		$this->SetFont('helvetica','', 7);
		$this->MultiCell(20, 3, $today, 0, 'L', 0, 1, 58, 58, true);


		//下半面,文字模板
		$this->SetFont('sansfallback','B', 14);
		$this->MultiCell(20, 10, '运单号', 0, 'L', 0, 1, 38, 65, true);

		$this->SetFont('sansfallback','', 8);
		$this->MultiCell(20, 6, '客户信息:', 0, 'L', 0, 1, 5, 71, true);
		$this->MultiCell(20, 6, '备注', 0, 'L', 0, 1, 64, 71, true);

//		$this->SetFont('sansfallback','', 6);
//		$this->MultiCell(60, 6, '寄方信息:上海浦东新区康桥镇康花路316号院内', 0, 'L', 0, 1, 5, 95, true);
//		$this->MultiCell(80, 6, '上海时品信息技术有限公司   叔小白  13651770441', 0, 'L', 0, 1, 5, 98, true);
//
//		$this->MultiCell(40, 6, '商家ID:  021K23664', 0, 'L', 0, 1, 63, 95, true);
		$this->MultiCell(80, 6, '商家订单号:   ', 0, 'L', 0, 1, 63, 98, true);
		$this->SetFont('sansfallback','', 5);
		$this->MultiCell(60, 6, '请您确认包裹完好,保留此包裹联时,代表您已经正常签收并确认外包裹完好', 0, 'L', 0, 1, 5, 102, true);
		$this->MultiCell(80, 6, '   http://www.jd-ex.com     客服电话:400-603-3600', 0, 'L', 0, 1, 5, 105, true);
		$this->SetFont('sansfallback','', 6);
		$this->MultiCell(80, 3, '始发城市:   ', 0, 'L', 0, 1, 63, 101, true);
		$this->SetFont('helvetica','', 7);
		$this->MultiCell(20, 3, $today, 0, 'L', 0, 1, 58, 108, true);
	}
}