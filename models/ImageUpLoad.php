<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpLoad extends Model{

    public $image;

    public function rules(): array
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png'] //правило чтоб загружались только выбраные форматы. Чтоб не грузить txt и др.
        ];
    }


    public function uploadFile(UploadedFile $file, $currentImage): string
    {
        $this->image = $file;

        if($this->validate())
        {
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }
        return $this->saveImage();
    }

    public function getFolder(): string
    {
        return Yii::getAlias('@webroot') . '/uploads/';
    }

    public function generateFilename(): string
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage){
        if($this->fileExists($currentImage))
        {
            @unlink(Yii::getAlias('@webroot') . '/uploads/' . $currentImage);
        }
    }

    public function fileExists($currentImage): bool
    {
            return file_exists($this->getFolder() . $currentImage);
    }

    public function saveImage(): string
    {
        $filename = $this->generateFilename();
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }
}

