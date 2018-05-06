<?php

namespace app\models;


/**
 * This is the model class for table "rate".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $desk_number
 * @property string $check_number
 * @property double $total
 * @property string $date_add
 *
 * @property CashDesk $deskNumber
 * @property Employee $employee
 */
class Rate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'desk_number', 'check_number'], 'required'],
            [['employee_id'], 'integer'],
            [['total'], 'number'],
            [['check_number', 'desk_number'], 'string', 'max' => 255],
            [['check_number', 'desk_number'], 'unique', 'targetAttribute' => ['check_number', 'desk_number']],
            [['desk_number'], 'exist', 'skipOnError' => true, 'targetClass' => CashDesk::class, 'targetAttribute' => ['desk_number' => 'desk_number']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Продавец',
            'desk_number' => 'Кассовый аппарат',
            'check_number' => 'Номер чека',
            'total' => 'Сумма по чеку',
            'date_add' => 'Date Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeskNumber()
    {
        return $this->hasOne(CashDesk::class, ['desk_number' => 'desk_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }
}
