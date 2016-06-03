<?php /* Smarty version 2.6.26, created on 2016-06-03 09:32:55
         compiled from simpla/system/index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_url', 'simpla/system/index.html', 18, false),array('modifier', 'cat', 'simpla/system/index.html', 64, false),)), $this); ?>
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
  <p id="page-intro">系统信息。</p>
  <div class="clear"></div>
  <div class="content-box">
    <div class="content-box-header">
      <h3>系统信息</h3>
      <div class="clear"></div>
    </div>
    <div class="content-box-content">
      <div class="tab-content default-tab" id="tab1">
        <div class="notification information png_bg"> <a href="#" class="close"><img src="<?php echo $this->_tpl_vars['root_dir']; ?>
/assets/simpla/images/icons/cross_grey_small.png" title="关闭" alt="close" /></a>
          <div> 商品总数：<?php echo $this->_tpl_vars['system']['goodscount']; ?>
 。已经销售的总金额：<?php echo $this->_tpl_vars['system']['salesall']['sm']; ?>
。库存商品总价：<?php echo $this->_tpl_vars['system']['salesall']['cm']; ?>
</div>
        </div>
        <div class="notification information png_bg">
          <div><a href="<?php echo smarty_function_get_url(array('rule' => "/plugins/index"), $this);?>
" target="_blank">导入数据</a></div>
        </div>
        <div class="content-box column-left">
          <div class="content-box-header">
            <h3 style="cursor: s-resize;">销售排行</h3>
          </div>
          <div class="content-box-content" style="display: block;">
            <div class="tab-content default-tab" style="display: block;">
              <table>
                <thead>
                  <tr>
                    <th>商品名称</th>
                    <th>销量</th>
                  </tr>
                </thead>
                <tbody>
                <?php unset($this->_sections['i']);
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['system']['salestop']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['name'] = 'i';
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
                  <td><?php echo $this->_tpl_vars['system']['salestop'][$this->_sections['i']['index']]['goods_name']; ?>
</td>
                  <td><?php echo $this->_tpl_vars['system']['salestop'][$this->_sections['i']['index']]['a']; ?>
</td>
                </tr>
                <?php endfor; endif; ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="content-box column-right">
          <div class="content-box-header">
            <h3 style="cursor: s-resize;">缺货的商品</h3>
          </div>
          <div class="content-box-content" style="display: block;">
            <div class="tab-content default-tab" style="display: block;">
              <table>
                <thead>
                  <tr>
                    <th>商品名称</th>
                    <th>库存</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                <?php unset($this->_sections['i']);
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['system']['goodsstock']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['name'] = 'i';
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
                  <td><?php echo $this->_tpl_vars['system']['goodsstock'][$this->_sections['i']['index']]['goods_name']; ?>
</td>
                  <td><?php echo $this->_tpl_vars['system']['goodsstock'][$this->_sections['i']['index']]['stock']; ?>
</td>
                  <td><a href="<?php echo smarty_function_get_url(array('rule' => "/purchase/purchase",'data' => ((is_array($_tmp="gid=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['system']['goodsstock'][$this->_sections['i']['index']]['goods_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['system']['goodsstock'][$this->_sections['i']['index']]['goods_id']))), $this);?>
">入库</a></td>
                </tr>
                <?php endfor; else: ?>
                <tr>
                  <td colspan="3">暂无缺货商品</td>
                </tr>
                <?php endif; ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="clear"></div>
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