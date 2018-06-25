<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html> 
    <head> 
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
        <?= Html::csrfMetaTags() ?>
        <link rel="icon" href="../images/7.ico" type="image/x-icon">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>      
    </head> 
    <body>  


<div class="modal modal-info" style="display: none;" id="mymodal-win">
          <div class="modal-dialog">
              <div class="modal-content" style="padding: 20px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">                 
              </div>
              <div class="modal-footer">                            
              </div>
            </div>
          </div>
</div>
   
        
        <?php $this->beginBody() ?>
            <input type="checkbox" class="toggle-nav" id="toggle-nav">
            <div class="mobile-bar">
                <label for="toggle-nav"></label>
            </div>  
            <div class="container">                
                <?= $content; ?>               
                <div class='footer'></div>
                <?php $this->endBody() ?>
            </div> 
            
<!-- $('#mymodal-win').on('hidden.bs.modal', function (e) { 
$(this).find('input,textarea,select').val('').end();
alert('Форма стерлась');
});           -->
            
<?php $this->registerJs("                
$('#mymodal-win').on('hidden.bs.modal', function (e) {      
$(this).removeData('bs.modal');  

});  
");
?>
</body>
</html>
<?php $this->endPage() ?>
