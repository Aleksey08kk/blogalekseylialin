<?php

namespace app\modules\admin\controllers;

use app\assets\DarkAsset;
use app\assets\PublicAsset;
use app\models\Article;
use app\models\ArticleSearch;
use app\models\Category;
use app\models\ImageUpLoad;
use app\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Article models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        } else {

            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetImage(int $id)
    {
        $model = new ImageUpLoad;

        if (Yii::$app->request->isPost) {
            $article = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'image');

            if ($article->saveImage($model->uploadFile($file, $article->image))) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }
        return $this->render('image', ['model' => $model]);
    }

    public function actionSetCategory(int $id)
    {
        $article = $this->findModel($id);
        $selectedCategory = $article->category->id;
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $category = Yii::$app->request->post('category');
            $article->saveCategory($category);
            if ($article->saveCategory(($category))) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }
        return $this->render('category', ['article' => $article, 'selectedCategory' => $selectedCategory, 'categories' => $categories]);
    }

    public function actionSetTags(int $id)
    {
        $article = $this->findModel($id);
        $selectedTags = $article->getSelectedTags(); 
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $tags = Yii::$app->request->post('tags');
            $article->saveTags($tags);
            return $this->redirect(['view', 'id' => $article->id]);
        }

        return $this->render('tags', [
            'selectedTags' => $selectedTags,
            'tags' => $tags
        ]);
    }
}
