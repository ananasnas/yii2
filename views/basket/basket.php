<?php
use yii\widgets\Menu;
use yii\grid\GridView;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\widgets\Pjax;
use app\models\Basket;
use app\models\BasketSearch;
use yii\widgets\ActiveForm;
use app\models\consignments;
use yii\helpers\Url;
use yii\helpers\Html;
    
$this->title = 'Корзина';   
?>
<div id='header'>   
        <header>        
	<div class="sh"></div>
	<div class="sh1"></div>
	<div class="sh"></div>
        <nav class="menu" style="font-size: 12pt;">                
                 
<?php
$items;

if(!\Yii::$app->user->isGuest){
    $identity = Yii::$app->user->identity;
    $items = getMenu($identity);  
}

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

            <div style="text-align: right; margin-right: 5px; color: dimgray;">
                <p style="margin-bottom: -4px;">Вы вошли под именем:</p>
                <?=$identity->surname;?>
                <?=$identity->name;?>
            </div>
         <div class="vvt panel pi">
                <?php 
                $url_=\yii\helpers\Url::to(['basket/create']);
                ?>
                <?=Html::a(
                    '<button class="btn btn-lg btn-block">Оформить заказ</button>', 
                    $url_, [
                      'data-toggle' => 'modal',
                      'data-target' => '#mymodal-win',
                      'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
                      'style' => 'text-decoration: none;',
                    ]
                  );?>
            </div> 
        <h1 style="text-align:center; margin-top:10px; margin-bottom: 30px;">Корзина</h1>

        <?php
        $searchModel = new BasketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        ?>
        <?php \yii\widgets\Pjax::begin(); ?>
        <?= GridView::widget([
                    'dataProvider' => $dataProvider, 

                    'id'=>'usong-grid',
                    'tableOptions' => [
                        'class' => 'table table-hover table-condensed table-bordered mytab_',
                       ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'productName',
                                'label'=>'Продукт',
                                'value' => function($model) {
                                     return $model->productsIDProduct->name; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                                }
                            ] ,
                            [
                                'attribute' => 'productPrice',
                                'label'=>'Цена',
                                'value' => function($model) {
                                     return $model->consignmentsIDConsignement->shipping_price; //здесь по идее можно писать любой код для подготовки вывода данных в колонке
                                }
                            ] ,

                            [
                                'attribute' => 'take_from_consignment',
                                'label'=>'Количество',                       
                            ] ,

                            [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [


                            'update' => function ($url, $model) {
                  return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>', 
                    $url, [
                      'data-toggle' => 'modal',
                      'data-target' => '#mymodal-win',
                      'onclick' => "$('#mymodel-win .modal-dialog .modal-content .modal-body').load($(this).attr('href'))",
                    ]
                  );
                },
                                ],
                                'template' => '{update} {delete}',
                            ],
                                    ],                               
                ]);
        ?>

        <?php
        $query = Basket::find()->where(['Persons_ID_person'=>$identity])->andWhere(['WasDel'=>0])->asArray()->all();
        $sum =0;

        foreach($query as $qu){  

            $cons = $qu['Consignments_ID_consignement'];
            $col = $qu['take_from_consignment'];
            $query_ = consignments::find()->where(['ID_consignment'=>$cons])->asArray()->all();

                foreach ($query_ as $qq)
                {
                    $sum = $sum + $qq['shipping_price']*$col;          
                }
        }

        ?>
        <div class="form-group" style="margin-left: 10%; font-size: 14pt;">
            <label>Итого:</label>
            <label><?= $sum;?></label>
        </div>

        <?php \yii\widgets\Pjax::end(); ?>
</article>
