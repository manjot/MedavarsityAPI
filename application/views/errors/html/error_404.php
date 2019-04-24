<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$this->load->view('templates/header');
$this->uri->segment(1);
if(!empty($this->uri->segment(1)) && $this->uri->segment(1) == "resource-centre") {
    $str = str_replace("resource-centre","rc", $_SERVER['REDIRECT_QUERY_STRING']);
    redirect($str);
    exit;
}
?>
<div id="container">
    <div class="col-sm-5 text-center">
        <img src="<?php echo HTTP_IMAGES_PATH ?>404.png" class="img404">
        <div class="clearfix"></div>
        <?php /* ?><h1><?php echo $heading; ?></h1>
          <?php echo $message; ?><?php */ ?>
    </div>
    <div class="col-sm-7">
        <h1 class="hdg404">Oops!</h1>
        <h2 class="shdg404">We are sorry, the page you were looking for does not exist anymore.</h2>
        <h4 class="txt404">Let us help you get <?php echo anchor('/', 'back to the site'); ?>.</h4>



    </div>
</div>
<?php
$this->load->view('templates/footer');
?>