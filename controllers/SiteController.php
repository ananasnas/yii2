<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\persons;
use yii\filters\VerbFilter;
use app\models\AuthorizationForm;
use app\models\User;
use yii\helpers\Html;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionLogout(){
        Yii::$app->user->logout();
        //Удаляем куки авторизации путем установления времени их жизни на текущий момент:
	setcookie('login', '', time()); //удаляем логин
	setcookie('key', '', time()); //удаляем ключ
        session('выход из системы');
        return $this->render('index');
    }
    
    public function actionLogin(){
        
      if (empty($_SESSION['auth']) or $_SESSION['auth'] == false) {
		//Проверяем, не пустые ли нужные нам куки...
		if ( !empty($_COOKIE['login']) and !empty($_COOKIE['key']) ) {
			
			$login = $_COOKIE['login']; 
			$key = $_COOKIE['key']; //ключ из кук (аналог пароля, в базе поле cookie)
                        $person=User::findOne(['login' => $login], ['cookie' => $key]); 
                         if(isset($person)){
                              Yii::$app->user->login($person); //логиним                   
                              session('вход в систему');             
                              return $this->render('index');
                         }
		}
      }
        
        $person_ = new persons();
        if($person_->load(Yii::$app->request->post()))
        {
            $pass = $person_->password;
            
            $person=User::findOne(['login' => $person_->login]); //модель user, но таблица правильная           
            if(isset($person)){
                
                $salt=$person->salt;              
                $salted = md5($pass.$salt);
                
                if($salted==$person->password)
                {
                    if ( !empty($_REQUEST['remember']) and $_REQUEST['remember'] == 1 ) {
			//Сформируем случайную строку для куки (используем функцию generateSalt):
			$key = generateSalt(); //назовем ее $key

			//Пишем куки (имя куки, значение, время жизни - сейчас+месяц)
			setcookie('login', $person['login'], time()+60*60*24*30); //логин
			setcookie('key', $key, time()+60*60*24*30); //случайная строка
                        
                        $person->cookie=$key;
                        $person->save();
                    }
                    
                    Yii::$app->user->login($person); //логиним                   
                    session('вход в систему');             
                    return $this->render('index');
                }
                else{
                return $this->render('login');  
            }
                
            }
            else{
                return $this->render('login');  
            }
        }
        else{                     
                return $this->render('login');  
        }
    }
//
//    public function actionRegistration(){  
//          $person_ = new \app\models\persons();
//           if($person_->load(Yii::$app->request->post()))
//           {  
//            echo $person_->name ;
//          }                
//    }
//    
    public function actionAuthorization(){
//        $authorizationModel = new AuthorizationForm();
//          if($authorizationModel->load(Yii::$app->request->post()))
//          {             
//              $identity = User::findOne(['login' => $authorizationModel->login]);          
//              if ($identity !=null){
//                   Yii::$app->user->login($identity); 
//                   return $this->render('index', compact('identity'));                     
//                 }
//              else{     
//                    return $this->render('authorization',['authorizationModel'=>$authorizationModel]);
//                  }
//           if (Yii::$app->user->can('controlCars')) {
//    echo'jhbhbhbhjbjh';
//}
//else{echo 'zxczdxczc ';}
           }
    //    return $this->render('authorization',['authorizationModel'=>$authorizationModel]);

    
  public function actionIndex()
    {    
//      $userModel = Yii::$app->user->identity;
//      if(isset($userModel))
//      { return $this->render('index', compact('userModel'));}
//      else {
          return $this->render('index');
    //  }
    }
   
}
