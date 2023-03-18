<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleTag;
use app\models\Category;
use app\models\Tag;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
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
    public function actionIndex()
    {
        $query = Article::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 3]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $popularArticles = Article::find()->orderBy('viewed desc')->limit(3)->all(); //сортировка по популярности статьи для вывода
        $sortByDate = Article::find()->orderBy('date asc')->limit(3)->all(); //сортировка по дате
        $categories = Category::find()->all(); //просто выводит все категории
        $tags = Tag::find()->all();  //выводит теги


        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination,
            'popularArticles' => $popularArticles,
            'sortByDate' => $sortByDate,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function actionView(int $id)
    {
        $article = Article::findOne($id);
        $comments = $article->getArticleComments();
        $commentForm = new CommentForm();
        $article->viewedCounter();
        $tags = Tag::find()->all();


        return $this->render('singlePost', [
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentForm,
            'tags' => $tags,

        ]);
    }

    public function actionTag(int $id)
    {
        $query = Article::find()->leftJoin('article_tag', 'article_tag.article_id=article.id')->where(['article_tag.tag_id' => $id]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('tag', [
            'articles' => $articles,
            'pagination' => $pagination]);
    }

    public function actionSinglePost()
    {
        return $this->render('singlePost');
    }

    public function actionCategory(int $id)
    {
        $query = Article::find()->where(['category_id' => $id]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('category', [
            'articles' => $articles,
            'pagination' => $pagination]);
    }


    public function actionComment(int $id)
    {
        $model = new CommentForm();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->saveComment($id)) {
                Yii::$app->getSession()->setFlash('comment', 'Ваш комментарий пройдет модерацию и добавится!');
                return $this->redirect(['site/view', 'id' => $id]);
            }
        }
    }


}
