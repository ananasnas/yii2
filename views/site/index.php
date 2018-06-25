<?php
use yii\widgets\Menu;
use app\models\User;
$this->title = 'Главная';
?>
<div id='header'>
 <!-- Header -->   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
       <nav class="menu" style="font-size: 12pt;">            
<?php
$items;
$identity= new User();
if(!\Yii::$app->user->isGuest){
    $identity = Yii::$app->user->identity;  
}
$items = getMenu($identity);  

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
   <?php if(isset($identity)):?>
    <div style="text-align: right; margin-right: 5px; color: dimgray;">
        <p style="margin-bottom: -4px;">Вы вошли под именем:</p>
        <?=$identity->surname;?>
        <?=$identity->name;?>
    </div>
  <?php endif;?>
<h1><b>О компании</b><h1>       
<p style="font-size:90%; margin-left:10px;">Компания начала свою деятельность на продовольственном рынке с 2017 года.  
Специализируется на оптовых поставках продуктов питания в рестораны, кафе, столовые, гостиницы и розничные сети.<p>
<p style="font-size:90%; margin-left:10px;">Миссия компании – быть самой успешной компанией в регионе, дать качественный и своевременный сервис нашим клиентам.<p>
</article>