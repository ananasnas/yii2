<?php
namespace app\controllers;
use app\models\persons;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;

class PersonsController extends AppController{
public function behaviors()
 {
      return [
           'verbs' => [
               'class' => VerbFilter::className(),
                'actions' => [
                  
                ],
            ],
        ];
    }
    public function actionUpdate($id){
        if((Yii::$app->user->can('managementEmployees')) || (Yii::$app->user->can('managementContactPersons')) ){
        $id_ = $id;
        $flag = 1;
        $person = new persons();
        
        if (($person->load(Yii::$app->request->post()))&&($person->validate()))
        {  
            
           $pers = persons::findOne($id_);           
           $pers->surname=$person->surname;
           $pers->name=$person->name;
           $pers->middle_name=$person->middle_name;
           $pers->login=$person->login;
          
          
           if(isset($person->pass))
           {             
               $salt = generateSalt();
               $pers->salt=$salt;
               $pers->password=md5($person->pass.$salt);
           }
           else
           {
               $salt = generateSalt();
               $pers->salt=$salt;
               $pers->password=md5($person->password.$salt);
           }
           
           $pers->mail=$person->mail;
           $pers->tel=$person->tel;
          
           $not_st = Yii::$app->formatter->asDate($person->not_availble_start, 'yyyy-MM-dd');
           $not_fin = Yii::$app->formatter->asDate($person->not_availble_finish, 'yyyy-MM-dd');
           
           $pers->not_availble_start=$not_st;         
           $pers->not_availble_finish=$not_fin;
           
           $pers->count_of_open_orders=$person->count_of_open_orders;
           $pers->Organizations_ID_organization=$person->Organizations_ID_organization;
           $pers->Groups_ID_group=$person->Groups_ID_group;         

            $select_1 = persons::find()->select(['position'])->distinct()->asArray()->all();
            $array =[];
                foreach ($select_1 as $mas)
                    {
                        foreach($mas as $el)
                        {
                            array_push($array, $el);
                        }
                    }

           $pers->position = $array[$person->position];
           $pers->WasDel=0;         
           $pers->save();
           session('редактирование человека');        
        }
        
         if(Yii::$app->request->isAjax){                
               return $this->renderAjax('_form', compact('id_', 'person', 'flag')); 
            }           
     if(!Yii::$app->request->isAjax){                  
            $this->redirect('/persons/all');
       } 
        }
         else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
    
    public function actionCreate(){
        if(Yii::$app->user->can('managementEmployees')){
        $id_ = 0;
        $flag = 1;
        $pers = new persons();
        $person = new persons();
       
        if (($person->load(Yii::$app->request->post()))&&($person->validate()))
        {           
           $pers->surname=$person->surname;
           $pers->name=$person->name;
           $pers->middle_name=$person->middle_name;
           $pers->login=$person->login;
            if(isset($person->pass))
           {             
               $salt = generateSalt();
               $pers->salt=$salt;
               $pers->password=md5($person->pass.$salt);
           }
           else
           {
               $salt = generateSalt();
               $pers->salt=$salt;
               $pers->password=md5($person->password.$salt);
           }
           
           $pers->mail=$person->mail;
           $pers->tel=$person->tel;
          
           $not_st = Yii::$app->formatter->asDate($person->not_availble_start, 'yyyy-MM-dd');
           $not_fin = Yii::$app->formatter->asDate($person->not_availble_finish, 'yyyy-MM-dd');
           $pers->not_availble_start=$not_st;         
           $pers->not_availble_finish=$not_fin;
           
           $pers->count_of_open_orders=$person->count_of_open_orders;
           $pers->Organizations_ID_organization=$person->Organizations_ID_organization;
           $pers->Groups_ID_group=8;         

    $select_1 = persons::find()->select(['position'])->distinct()->asArray()->all();
    $array =[];
        foreach ($select_1 as $mas)
            {
                foreach($mas as $el)
                {
                    array_push($array, $el);
                }
            }

           $pers->position = $array[$person->position];
           $pers->WasDel=0;         
           $pers->save();  
           session('создание человека');
               
            }
        
         if(Yii::$app->request->isAjax){                
               return $this->renderAjax('_form', compact('id_', 'person', 'flag')); 
            }           
     if(!Yii::$app->request->isAjax){                  
            $this->redirect('/persons/all');
       } 
        }
     
       else if((Yii::$app->user->can('managementContactPersons'))&&(!Yii::$app->user->can('managementEmployees'))){
                    $id_ = 0;
        $flag = 1;
        $pers = new persons();
        $person = new persons();
       
        if ((Yii::$app->request->isAjax)&&($person->load(Yii::$app->request->post())))
        {           
           $pers->surname=$person->surname;
           $pers->name=$person->name;
           $pers->middle_name=$person->middle_name;
     
          $pers->login=$person->login;
            if(isset($person->pass))
           {             
               $salt = generateSalt();
               $pers->salt=$salt;
               $pers->password=md5($person->pass.$salt);
           }
           else
           {
               $salt = generateSalt();
               $pers->salt=$salt;
               $pers->password=md5($person->password.$salt);
           }
           
           $pers->mail=$person->mail;
           $pers->tel=$person->tel;
          
           $not_st = Yii::$app->formatter->asDate($person->not_availble_start, 'yyyy-MM-dd');
           $not_fin = Yii::$app->formatter->asDate($person->not_availble_finish, 'yyyy-MM-dd');
           $pers->not_availble_start=$not_st;         
           $pers->not_availble_finish=$not_fin;
           
           $pers->count_of_open_orders=$person->count_of_open_orders;
           $pers->Organizations_ID_organization=$person->Organizations_ID_organization;
           $pers->Groups_ID_group=9;         

    $select_1 = persons::find()->select(['position'])->distinct()->asArray()->all();
    $array =[];
        foreach ($select_1 as $mas)
            {
                foreach($mas as $el)
                {
                    array_push($array, $el);
                }
            }

           $pers->position = $array[$person->position];
           $pers->WasDel=0;         
           $pers->save();  
           session('создание человека');
                  }
        
         if(Yii::$app->request->isAjax){                
               return $this->renderAjax('_form', compact('id_', 'person', 'flag')); 
            }           
     if(!Yii::$app->request->isAjax){                  
            $this->redirect('/persons/all');
       } 
        }
    }

    public function actionDelete($id){
    if((Yii::$app->user->can('managementEmployees')) || (Yii::$app->user->can('managementContactPersons')) ){
            $id_ = $id;
            $person = persons::findOne($id_);
            $person->WasDel = '1';
            $person->save();       
            session('удаление человека');
   
                $identity = Yii::$app->user->identity;
                $id_group = $identity->Groups_ID_group;
                if ($id_group==10){
                    $query = persons::find()->where(['Groups_ID_group' => 8]); //8 сотрудники
                }
                else{
                $query = persons::find()->where(['Groups_ID_group' => 9]); //9 клиенты
                }

                $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 
                    3, 'forcePageParam' => false, 'pageSizeParam' => false]);
                $persons_ =$query->offset($pages->offset)->limit($pages->limit)->all();     
                
            if(Yii::$app->request->isAjax){                
                return $this->renderPartial('all', compact('persons_', 'pages')); 
            }
               return $this->redirect('all', compact('persons_', 'pages'));             
         }
         else{
            throw new ForbiddenHttpException('Access denied');    
        }
    }
    
    public function actionView($id)
    {
        $id_ = $id;
        $flag = 0;
        return $this->renderAjax('_form', compact('id_', 'flag'));       
    }

    public function actionAll(){
            
            $identity = Yii::$app->user->identity;
            $id_group = $identity->Groups_ID_group;
            if ($id_group==10){
                $query = persons::find()->where(['Groups_ID_group' => 8]); //8 сотрудники
            }
            else{
            $query = persons::find()->where(['Groups_ID_group' => 9]); //9 клиенты
            }
            
            $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 
                3, 'forcePageParam' => false, 'pageSizeParam' => false]);
            $persons_ =$query->offset($pages->offset)->limit($pages->limit)->all();      
            return $this->render('all', compact('persons_', 'pages'));       
    }   
}
