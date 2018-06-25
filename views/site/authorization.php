<?php
use yii\widgets\Menu;
use app\models\persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Главная';
?>
<div id='header'>
 <!-- Header -->   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu" style="font-size: 12pt;"/>                                   
      <?php
//      $id_group = 20;
//      try{
//        $id_group = $identity->Groups_ID_group;
//      }
//      catch (Exception $e){
//         
//      }
$items = getItems('20');
echo Menu::widget([
    'items' => $items,
    'options' => [
    ],   
    'itemOptions' => [    
        'tag' => false
    ]
]);
?>      
            </nav> 
        </header>			
</div>
<article class="content">  
<h1 style="margin-top:10%;">Вход в систему</h1>
<p style="text-align: center; font-size:14pt; margin-top: 30px; margin-bottom: 30px;">Пожалуйста, введите свои логин и пароль для входа в систему:<p>
    <div style="display:flex; justify-content:center; ">
        <?php $form = ActiveForm::begin(['id'=>'autoriz'])?>
        <p>Логин</p>
        <?= $form->field($authorizationModel, 'login')->label(false)?>
        <p style="margin-top: 10px;">Пароль</p>
<!--       в хроме поле пароля отображается нормально  -->
        <?= $form->field($authorizationModel, 'password')->passwordInput()->label(false)?>  
        <?php $form = ActiveForm::end()?>    
    </div>
   
    <div class="v panel pi" >
        <a href=""><?= Html::submitButton('Войти', ['class'=>'v panel pi', 'form'=>'autoriz'])?></a>
    </div>
</article>