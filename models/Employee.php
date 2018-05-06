<?php

namespace app\models;


use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $photo
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['last_name', 'first_name', 'middle_name', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'photo' => 'Фото',
        ];
    }

    public function upload()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($this->validate()) {
            $imageName = $this->id . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs('images/origin/' . $imageName) === true) {
                Image::thumbnail('@webroot/images/origin/' . $imageName, 150, 200)
                    ->save(\yii::getAlias('@webroot/images/thumb/' . $imageName), ['quality' => 80]);
                Image::thumbnail('@webroot/images/origin/' . $imageName, 600, 800)
                    ->save(\yii::getAlias('@webroot/images/800x600/' . $imageName), ['quality' => 80]);
                $this->photo = $imageName;
                return $this->save(true, ['photo']);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
