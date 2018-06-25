<?php
use yii\widgets\Menu;
use yii\helpers\Html;
$this->title = 'Ассортимент';
?>
<div id='header'> 
    <header>        
        <div class="sh"></div>
        <div class="sh1"></div>
        <div class="sh"></div>
        <nav class="menu" style="font-size: 12pt;">            
<?php
$items;
$identity;
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
<?php if(!\Yii::$app->user->isGuest):?>    
    <div style="text-align: right; margin-right: 5px; color: dimgray;">
        <p style="margin-bottom: -4px;">Вы вошли под именем:</p>
        <?=$identity->surname;?>
        <?=$identity->name;?>
    </div>
<?php endif;?>
<?php \yii\widgets\Pjax::begin(); ?>
<h1 style="margin-bottom: 20px;">Ассортимент</h1>
<?php if(!empty($categories_)):?>

<div class="container" style="text-align: center;">
        <div class="row">
            <?php foreach ($categories_ as $category):?>
            <div class ="col-md-3" >           
                    <a href="<?=\yii\helpers\Url::to(['categories/all', 'ID_category' => $category['ID_category']])?>">	
                        <?=Html::img("@web/images/{$category->img}",
                                ['alt'=> $category->name, 'title' => "Открыть категорию"])?>
                            <h3 style="font-family: Times New Roman; font-size: 14pt; margin-bottom: 30px;"><?= $category->name?></h3>
                    </a>           
            </div>
            <?php endforeach;?>
        </div>
</div>

<?php endif; ?>
<?php \yii\widgets\Pjax::end(); ?>
</article>