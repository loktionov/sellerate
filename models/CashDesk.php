<?php

namespace app\models;


/**
 * This is the model class for table "cash_desk".
 *
 * @property int $id
 * @property string $desk_number
 * @property string $description
 * @property string $date_add
 *
 * @property Rate[] $rates
 */
class CashDesk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cash_desk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desk_number'], 'required'],
            [['date_add'], 'safe'],
            [['desk_number', 'description'], 'string', 'max' => 255],
            [['desk_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desk_number' => 'Номер кассы',
            'description' => 'описание',
            'date_add' => 'добавлен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRates()
    {
        return $this->hasMany(Rate::class, ['desk_number' => 'desk_number']);
    }
}
