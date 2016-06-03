<?php /* Smarty version 2.6.26, created on 2016-06-03 09:45:54
         compiled from simpla/sales/index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_url', 'simpla/sales/index.html', 12, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "simpla/common/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "simpla/common/left.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="main-content">
  <h2>欢迎您 <?php echo $this->_tpl_vars['_adminname']; ?>
</h2>
  <p id="page-intro">查看商品的销售明细。</p>
  <div class="clear"></div>
  <div class="content-box">
    <div class="content-box-header">
      <h3>销售明细</h3>
      <ul class="content-box-tabs">
        <li><a href="#tab1" class="default-tab">销售明细</a></li>
        <li><a href="<?php echo smarty_function_get_url(array('rule' => "/sales/sales"), $this);?>
">商品出库</a></li>
        <li><a href="<?php echo smarty_function_get_url(array('rule' => "/sales/return"), $this);?>
">商品退货</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <div class="content-box-content">
      <div class="tab-content default-tab" id="tab1">
        <div class="form">
          <form id="js-form" method="post" action="<?php echo smarty_function_get_url(array('rule' => '/sales/index'), $this);?>
">
            <fieldset class="clearfix">
              <p>开始时间： <span>
                <input type="text" value="<?php echo $this->_tpl_vars['stime']; ?>
" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="text-input min-input" name="stime" />
                </span>&nbsp;结束时间： <span>
                <input type="text" value="<?php echo $this->_tpl_vars['etime']; ?>
" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="text-input min-input" name="etime" />
                </span><small>(格式：2012-01-01)</small> </p>
              <p>关键字：<span>
                <input type="text" value="<?php echo $this->_tpl_vars['key']; ?>
" class="text-input small-input" name="key" />
                &nbsp;<small>商品名称，订单号，客户名字，会员卡号</small>&nbsp;
                <input type="submit" name="" id="button" class="button" value="查询" />
                </span> </p>
            </fieldset>
          </form>
        </div>
        <hr />
        <table>
          <thead>
            <tr>
              <th>订单号</th>
              <th>名称</th>
              <th>数量</th>
              <th>实际售价</th>
              <th>优惠(促销/会员)</th>
              <th>退款</th>
              <th>销售时间</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td colspan="7"><?php echo $this->_tpl_vars['pagebar']; ?>
</td>
            </tr>
          </tfoot>
          <tbody>
          <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['sales']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
          <tr>
            <td><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['order_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['goods_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['price']*$this->_tpl_vars['sales'][$this->_sections['i']['index']]['num']; ?>
</td>
            <td><?php if ($this->_tpl_vars['sales'][$this->_sections['i']['index']]['p_discount'] > 0): ?><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['p_discount']; ?>
元<?php else: ?>无<?php endif; ?>/<?php if ($this->_tpl_vars['sales'][$this->_sections['i']['index']]['m_discount'] > 0): ?><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['m_discount']; ?>
元<?php else: ?>无<?php endif; ?></td>
            <td><?php if ($this->_tpl_vars['sales'][$this->_sections['i']['index']]['refund_type'] == 0): ?>无退款<?php else: ?><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['refund_amount']; ?>
元<?php endif; ?></td>
            <td><?php echo $this->_tpl_vars['sales'][$this->_sections['i']['index']]['dateymd']; ?>
</td>
          </tr>
          <?php endfor; else: ?>
          <tr>
            <td colspan="7" align="center">没有数据</td>
          </tr>
          <?php endif; ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "simpla/common/copy.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "simpla/common/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 