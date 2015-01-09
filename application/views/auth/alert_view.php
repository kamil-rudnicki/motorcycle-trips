<?php include($this->config->item('views_path').'_header.php'); ?>
<section>
<div class="container">
<?php
if (isset($title)):
?>
<div class="page-header">
<h1><?=$title?></h1>
</div><!--page-header-->
<?php
elseif ($this->session->flashdata('alert_page_title') != ''):
?>
<div class="page-header">
<h1><?=$this->session->flashdata('alert_page_title')?></h1>
</div><!--page-header-->
<?php
endif;
if (isset($message)):
?>
<p><?=$message?></p>
<?php
else:
	echo $this->ci_alerts->display();
endif;
?>
</div><!--container-->
</section>
<?php include($this->config->item('views_path').'_footer.php');