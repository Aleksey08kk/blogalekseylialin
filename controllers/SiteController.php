<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CommentForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function actionIndex(){
        $query = Article::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>3]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $popularArticles = Article::find()->orderBy('viewed desc')->limit(3)->all(); //сортировка по популярности статьи для вывода
        $sortByDate = Article::find()->orderBy('date asc')->limit(3)->all(); //сортировка по дате
        $categories = Category::find()->all(); //просто выводит все категории

        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination,
            'popularArticles' => $popularArticles,
            'sortByDate' => $sortByDate,
            'categories' => $categories
        ]);
    }

    public function actionView($id){
        $article = Article::findOne($id);
        $comments = $article->getArticleComments();
        $commentForm = new CommentForm();
        $article->viewedCounter();

        return$this->render('singlePost', [
            'article'=>$article,
            'comments'=>$comments,
            'commentForm'=>$commentForm,
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(){
        return $this->render('about');
    }

    public function actionSinglePost(){
        return $this->render('singlePost');
    }

    public function actionCategory($id){
        $query = Article::find()->where(['category_id'=>$id]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>5]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('category', [
            'articles' => $articles,
            'pagination' => $pagination]);
    }

    public function actionComment($id){
        $model = new CommentForm();
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if($model->saveComment($id)){
                Yii::$app->getSession()->setFlash('comment', 'Ваш комментарий пройдет модерацию и добавится!');
                return $this->redirect(['site/view','id'=>$id]);
            }
        }
    }


}
