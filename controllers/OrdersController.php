<?php

namespace app\controllers;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAll(){
         return $this->render('all');
    }
  
    public function actionView(){
        $id_ = $_GET['id'];
        $flag = 0;
        return $this->renderAjax('_form', compact('id_', 'flag'));       
    }
     public function actionUpdate(){
        if(Yii::$app->user->can('managementAllOrders'))
        {
            $id_ = $_GET['id'];
            $flag = 1;
            $order = new Orders();
            if ((Yii::$app->request->isAjax)&&($order->load(Yii::$app->request->post()))&&($order->validate()))
            {  
               $order_ = Orders::findOne($id_);
               $order_->comment=$order->comment;
               $order_->date_of_order=$order->date_of_order;
               $order_->delivery_address=$order->delivery_address;
               $order_->delivery_date=$order->delivery_date;
               $order_->number_of_delivered_units=$order->number_of_delivered_units;
               $order_->order_status=$order->order_status;
               $order_->prepayment=$order->prepayment;
               $order_->Cars_ID_car=$order->Cars_ID_car;
               $order_->WasDel=0;
               $order_->Organizations_ID_organization=$order->Organizations_ID_organization;
               $order_->save();
               session('обновление заказа');
               return $this->redirect(Yii::$app->request->referrer); 

            }
            else {
                 return $this->renderAjax('_form', compact('id_', 'order', 'flag')); 
            }
        }
        else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
     public function actionDelete(){
         if(Yii::$app->user->can('managementAllOrders'))
        {
            $id_ = $_GET['id'];
            $order = Orders::findOne($id_);
            $order->WasDel = '1';
            $order->save();      
            session('удаление заказа');
            return $this->redirect(Yii::$app->request->referrer); 
        }
         else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
}
