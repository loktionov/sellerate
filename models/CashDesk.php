<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cash_desk".
 *
 * @property int $id
 * @property string $desk_number
 * @property string $date_add
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
            [['desk_number', 'date_add'], 'required'],
            [['date_add'], 'safe'],
            [['desk_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desk_number' => 'Desk Number',
            'date_add' => 'Date Add',
        ];
    }
}
