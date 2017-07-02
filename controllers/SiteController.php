<?php

namespace app\controllers;

use app\models\Chat;
use app\models\Online;
use app\models\User;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    private $limitMessages = 30;
    private $lastId = 0;
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $err = false;
        $type = Yii::$app->request->get('type');

        if(!is_null($type)){
            Yii::$app->response->format =  \yii\web\Response::FORMAT_JSON;
            $lastId = Yii::$app->request->get('lastId');
            switch ($type){
                case 'getMessages':
                                $this->removeOfflineUsers();
                                $messages = $this->getChatMessages($lastId);
                                return ['data' => $messages, 'lastId'=>$this->lastId];
                            break;
                case 'online':
                                return ['data' => $this->viewOnlineUsers()];
                            break;
                case 'connect':
                                $userName = Yii::$app->request->get('name');
                                $userMsg = strip_tags(Yii::$app->request->get('msg'));
                                $userInfo = Yii::$app->request->get('info');
                                $userInfo = json_decode($userInfo,true);

                                if (!isset(Yii::$app->request->cookies['idUser'])) {
                                    $user = new User();
                                    $user->name = $userName;
                                    $user->city = $userInfo['city'];
                                    $user->ip = new Expression('INET_ATON(:ip)', array(':ip' => $userInfo['ip'],));
                                    $user->created_at = time();

                                    if (!$err && $user->validate() && $user->save()) {
                                        $userId = $user->getPrimaryKey();
                                    }

                                }else{
                                    $user = User::findIdentity(Yii::$app->request->cookies['idUser']);
                                    $userName = $user->name;
                                    $userId = $user->id;
                                }
                                $this->saveMessage($userId,$userMsg);

                                return [ 'idUser'=>$userId, 'nameUser'=>$userName,];
                            break;
                case 'send':
                                $userId = Yii::$app->request->get('userId');
                                $userMsg = strip_tags(Yii::$app->request->get('msg'));
                                return [ 'response'=>$this->saveMessage($userId,$userMsg) ];
                            break;
                default:
                            return [ 'response'=>'No response' ];
            }
        }

        return $this->render('index');
    }

    protected function saveMessage($userId,$userMsg)
    {

        $chat = new Chat();
        $chat->user = $userId;
        $chat->msg = $userMsg;
        $chat->created_at = time();
        if ($chat->validate() && $chat->save()) {

            $this->setOnlineUser($userId);

            return $chat->getPrimaryKey(Yii::$app->request->cookies['idUser']);
        }else{
            return false;
        }
    }

    protected function viewOnlineUsers()
    {
        $this->removeOfflineUsers();
        $users = Online::find()->joinWith('users','user.id = online.user')->orderBy('name')->all();

        return $this->renderPartial('online', [
            'users' => $users,
        ]);
    }

    protected function setOnlineUser($userId)
    {
        $onlineUser = Online::findOne(['user'=>$userId]);

        if(is_null($onlineUser)){
            $onlineUser = new Online();
        }

        $onlineUser->user = $userId;
        $onlineUser->updated_at = time();

        if ($onlineUser->validate() ) {
            return $onlineUser->save();
        }

        return $onlineUser->errors;
    }

    protected function removeOfflineUsers()
    {
            Online::deleteAll( 'updated_at < unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 5 MINUTE)  ');
    }

    protected function getChatMessages($lastId=0)
    {
        $maxId = Chat::find()->max('id');

        if($lastId < 0){
            $lastId = 0;
        }
        $this->lastId = $maxId;
        $messages = Chat::find()->joinWith('users','user.id = chat.user')->orderBy('id')->Where(['and',['>','chat.id',$lastId],['<=','chat.id',$maxId]])->all();
        return $this->renderPartial('chat', [
            'messages' => $messages,
        ]);


    }
}
