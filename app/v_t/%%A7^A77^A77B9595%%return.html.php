<?php /* Smarty version 2.6.26, created on 2016-06-03 09:46:03
         compiled from simpla/sales/return.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_url', 'simpla/sales/return.html', 11, false),)), $this); ?>
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
<p id="page-intro">商品退货！</p>
<div class="clear"></div>
<div class="content-box">
  <div class="content-box-header">
    <h3>商品退货</h3>
    <ul class="content-box-tabs">
      <li><a href="<?php echo smarty_function_get_url(array('rule' => "/sales/index"), $this);?>
">销售明细</a></li>
      <li><a href="<?php echo smarty_function_get_url(array('rule' => "/sales/sales"), $this);?>
">商品出库</a></li>
      <li><a href="#tab1" class="default-tab">商品退货</a></li>
    </ul>
    <div class="clear"></div>
  </div>
  <div class="content-box-content">
    <div class="tab-content default-tab" id="tab1">
      <div class="form">
        <form action="<?php echo smarty_function_get_url(array('rule' => '/sales/return'), $this);?>
" method="post" id="js-form">
          <fieldset class="clearfix">
            <p>订单号：
              <span>
              <input type="text" value="" class="text-input small-input" name="order_id" />
              </span>&nbsp;<input type="submit" name="" class="button" id="button" value="查询" /></p>
          </fieldset>
        </form>
      </div>
      <?php if ($this->_tpl_vars['order_id']): ?>
      <hr />
      <div class="form">
        <form action="<?php echo smarty_function_get_url(array('rule' => '/sales/return'), $this);?>
" method="post" id="js-form2">
          <fieldset class="clearfix">
            <input type="hidden" name="ac" value="del" />
            <input type="hidden" name="order_id" value="<?php echo $this->_tpl_vars['order_id']; ?>
" />
            <table>
              <thead>
                <tr>
                  <th><input type="checkbox" class="check-all">全选</th>
                  <th>名称</th>
                  <th>数量</th>
                  <th>总价</th>
                  <th>销售时间</th>
                </tr>
              </thead>
              <tbody>
              <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
              <tr> <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['refund_type'] == 0): ?>
                <td><input type="checkbox" name="sid[<?php echo $this->_sections['i']['index']; ?>
]" class="ck" value="<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['sid']; ?>
" /></td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['goods_name']; ?>
</td>
                <td><input type="text" name="num[<?php echo $this->_sections['i']['index']; ?>
]" class="text-input min-input" value="<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['num']; ?>
" /></td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['price']*$this->_tpl_vars['list'][$this->_sections['i']['index']]['num']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['dateymd']; ?>
</td>
                <?php else: ?>
                <td colspan="5">商品：<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['goods_name']; ?>
，已经有过退款记录不能够再次退款！退款金额：<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['refund_amount']; ?>
元</td>
                <?php endif; ?> </tr>
              <?php endfor; else: ?>
              <tr>
                <td colspan="5">没有该订单信息</td>
              </tr>
              <?php endif; ?>
              <tr>
                <td colspan="5"><input type="submit" class="button" value="确认退货" /></td>
              </tr>
                </tbody>
            </table>
          </fieldset>
        </form>
      </div>
      <?php endif; ?> </div>
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