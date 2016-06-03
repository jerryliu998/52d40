<?php /* Smarty version 2.6.26, created on 2016-06-03 09:45:56
         compiled from simpla/sales/sales.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_url', 'simpla/sales/sales.html', 11, false),)), $this); ?>
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
  <p id="page-intro">商品销售。带<font class="red"> * </font>为必填项目。先把商品加入订单。所有商品都加人订单后点<font class="red">确认提交</font>完成！</p>
  <div class="clear"></div>
  <div class="content-box">
    <div class="content-box-header">
      <h3>商品销售</h3>
      <ul class="content-box-tabs">
        <li><a href="<?php echo smarty_function_get_url(array('rule' => "/sales/index"), $this);?>
">销售明细</a></li>
        <li><a href="#tab1" class="default-tab">商品出库</a></li>
        <li><a href="<?php echo smarty_function_get_url(array('rule' => "/sales/return"), $this);?>
">商品退货</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <div class="content-box-content">
      <div class="tab-content default-tab" id="tab1">
        <div class="form">
          <form action="<?php echo smarty_function_get_url(array('rule' => '/sales/sales'), $this);?>
" method="post" id="js-form">
            <fieldset class="clearfix">
                <p>
                  <label class="w80"><font class="red"> * </font>商品条形码：</label>
                  <span>
                  <input type="text" value="" class="text-input small-input" name="goods_sn" id="goods_sn" />
                  </span> </p>
                <p>
                  <label class="w80"><font class="red"> * </font>数量：</label>
                  <span>
                  <input type="text" value="1" class="text-input min-input" name="num" />
                  </span> <small>计重商品单位为千克</small></p>
              <dt>
                <input type="submit" name="" id="button" class="button" value="加人订单" />&nbsp;<a href="<?php echo smarty_function_get_url(array('rule' => '/sales/sales','data' => "ac=del"), $this);?>
">重新出库</a> </dt>
            </fieldset>
          </form>
        </div>
        <hr />
        <table>
          <thead>
            <tr>
              <th>名称</th>
              <th>数量</th>
              <th>单价（元）</th>
              <th>总价（元）</th>
              <th>优惠总价（元）</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td colspan="5"><?php echo $this->_tpl_vars['pagebar']; ?>
</td>
            </tr>
          </tfoot>
          <tbody>
          <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['info']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
          <?php $this->assign('impress', $this->_tpl_vars['info'][$this->_sections['i']['index']]['out_price']*$this->_tpl_vars['info'][$this->_sections['i']['index']]['num']); ?>
          <tr>
            <td><?php echo $this->_tpl_vars['info'][$this->_sections['i']['index']]['goods_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['info'][$this->_sections['i']['index']]['num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['info'][$this->_sections['i']['index']]['out_price']; ?>
</td>
            <td><?php echo $this->_tpl_vars['info'][$this->_sections['i']['index']]['out_price']*$this->_tpl_vars['info'][$this->_sections['i']['index']]['num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['info'][$this->_sections['i']['index']]['p_discount']*$this->_tpl_vars['info'][$this->_sections['i']['index']]['num']; ?>
</td>
          </tr>
          <?php endfor; else: ?>
          <tr>
            <td colspan="5">暂无商品</td>
          </tr>
          <?php endif; ?>
          <tr>
            <th colspan="5" align="right">总价：<?php echo $this->_tpl_vars['total']; ?>
元，优惠：<?php echo $this->_tpl_vars['discount']; ?>
元。<span class="red">小计：<?php echo $this->_tpl_vars['total']-$this->_tpl_vars['discount']; ?>
元</span></th>
          </tr>
            </tbody>
        </table>
        <div class="form">
          <form action="<?php echo smarty_function_get_url(array('rule' => '/sales/out','data' => "oid=".($this->_tpl_vars['order_id'])), $this);?>
" method="post" id="js-form2">
            <fieldset class="clearfix">
                <p>
                  <label class="w80">会员卡号：</label>
                  <span>
                  <input type="text" value="" class="text-input small-input" name="cardid" />
                  </span><br /><small>填写会员卡卡号</small></p>
              <dt>
                <input type="submit" name="" class="button" id="button" value="确认提交" />
              </dt>
            </fieldset>
          </form>
        </div>
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