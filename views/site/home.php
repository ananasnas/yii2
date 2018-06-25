<?php
use yii\widgets\Menu;
$this->title = 'Главная';
?>
<div id='header'>
 <!-- Header -->   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu">                                   
      <?php 
$items = getItems(10);
echo Menu::widget([
    'items' => $items,
    'options' => [
    ],   
    'itemOptions' => [    
        'tag' => false
    ]
]);?>      
            </nav> 
        </header>			
</div>
<article class="content">  
<h1 style="margin-bottom: 20px;">О компании</h1>
<p style="font-size:90%; margin-left:10px;">Компания начала свою деятельность на продовольственном рынке с 2017 года.  
Специализируется на оптовых поставках продуктов питания в рестораны, кафе, столовые, гостиницы и розничные сети.<p>
<p style="font-size:90%; margin-left:10px;">Миссия компании – быть самой успешной компанией в регионе, дать качественный и своевременный сервис нашим клиентам.<p>
</article>