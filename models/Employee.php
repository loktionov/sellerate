<?php

namespace app\models;


use yii\web\UploadedFile;

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
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg'],
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

        $imageName = $this->id . '.' . $this->imageFile->extension;
        $path = realpath(\yii::getAlias('@webroot') . \yii::$app->params['imagesPath']);
        if (!empty($this->imageFile) AND $this->imageFile->saveAs($path . DIRECTORY_SEPARATOR . $imageName) === true) {
            $this->photo = $imageName;
            return $this->save(true, ['photo']);
        } else if (empty($this->photo)) {
            return false;
        }
        return true;
    }
}
