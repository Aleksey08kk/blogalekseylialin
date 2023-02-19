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

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
    public function actionIndex()
    {
        // build a DB query to get all articles with status = 1
        $query = Article::find();

// get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

// create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>3]);

// limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $popularArticles = Article::find()->orderBy('viewed desc')->limit(3)->all(); //сортировка по популярности статьи для вывода
        $sortByDate = Article::find()->orderBy('date asc')->limit(4)->all(); //сортировка по дате
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
        return$this->render('singlePost', ['article'=>$article,]);
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
        // build a DB query to get all articles with status = 1
        $query = Article::find()->where(['category_id'=>$id]);

// get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

// create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>5]);

// limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('category', [
            'articles' => $articles,
            'pagination' => $pagination]);
    }
}
