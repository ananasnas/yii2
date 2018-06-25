<?php
namespace app\controllers;
use app\models\organizations;
use Yii;
use app\models\CarsSearch;
use yii\data\Pagination;

class OrganizationsController extends AppController{
 
    public function actionAll(){ 
        return $this->render('all');
    }
    
    public function actionView($id){
        $id_ = $id;
        $flag = 0;
        return $this->renderAjax('_form', compact('id_', 'flag'));       
    }
    
    public function actionCreate(){    
        if(Yii::$app->user->can('managementContactPersons'))
        {
            $id_ = 0;
            $flag = 1;
            $organization_ = new organizations();
            $organization = new organizations();

            if ((Yii::$app->request->isAjax)&&($organization->load(Yii::$app->request->post()))&&($organization->validate()))
            {                             
               $organization_->name=$organization->name;
               $organization_->address=$organization->address;
               $organization_->bank_account=$organization->bank_account;
               $organization_->discount=$organization->discount;
               $organization_->inn=$organization->inn;
               $organization_->comment=$organization->comment;
               $organization_->ownership=$organization->ownership;
               $organization_->WasDel=0;

               $organization_->save(); 
               session('создание организации');
    //           var_dump($prod->errors);
    //           return $this->render('ind', compact('prod'));
               return $this->redirect(Yii::$app->request->referrer);         
            }
            else {
                return $this->renderAjax('_form', compact('id_', 'organization', 'flag')); 
            }   
        }
          else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
    
    public function actionUpdate($id){
        if(Yii::$app->user->can('managementContactPersons'))
        {
            $id_ = $id;
            $flag = 1;
            $organization = new organizations();
            if ((Yii::$app->request->isAjax)&&($organization->load(Yii::$app->request->post()))&&($organization->validate()))
            {  
               $organization_ = organizations::findOne($id_);

               $organization_->name=$organization->name;
               $organization_->address=$organization->address;
               $organization_->bank_account=$organization->bank_account;
               $organization_->discount=$organization->discount;
               $organization_->inn=$organization->inn;
               $organization_->comment=$organization->comment;
               $organization_->ownership=$organization->ownership;
               $organization_->WasDel=0;
               $organization_->save();
               session('обновление организации');
               return $this->redirect(Yii::$app->request->referrer); 

            }
            else {
                 return $this->renderAjax('_form', compact('id_', 'organization', 'flag')); 
            }
        }
        else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
     public function actionDelete($id){
         if(Yii::$app->user->can('managementContactPersons'))
        {
            $id_ = $id;
            $organization = organizations::findOne($id_);
            $organization->WasDel = '1';
            $organization->save();   
            session('удаление организации');
            return $this->redirect(Yii::$app->request->referrer); 
        }
        else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
}
