<?php
use yii\widgets\Menu;
use app\models\persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Вход';
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
<?php 
$person = new persons();
?>    
<h1 style="margin-top:10%;">Вход в систему</h1>
<p style="text-align: center; font-size:14pt; margin-top: 30px; margin-bottom: 30px;">Пожалуйста, введите свои логин и пароль для входа в систему:<p>
    <div style="display:flex; justify-content:center; ">
        <?php $form = ActiveForm::begin(['id'=>'form_'])?> 
        
            <p style="margin-top: 10px;">Логин</p>
            <?= $form->field($person, 'login')->label(false)?>
            
            <p style="margin-top: 10px;">Пароль</p>
            <?= $form->field($person, 'password')->label(false)->passwordInput()?>
            
            <input name='remember' type='checkbox' value='1'> <span>Запомнить меня</span>
            
            <div class="v panel pi" >
                <?= Html::submitButton('Войти', ['class'=>'v panel pi'])?>
            </div>
        <?php $form = ActiveForm::end()?>    
    </div> 
</article>