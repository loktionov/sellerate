<?php

namespace app\models;

use kartik\daterange\DateRangeBehavior;
use yii\data\ActiveDataProvider;
use yii\db\Query;


/**
 * This is the model class for table "rate".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $desk_number
 * @property string $check_number
 * @property double $total
 * @property string $date_add
 * @property string $date_purchase
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


    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
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
            [['check_number', 'desk_number'], 'unique', 'targetAttribute' => ['check_number', 'desk_number'],
                'message' => 'Этот чек уже использовался,<br>поднеси другой'],
            [['desk_number'], 'exist', 'skipOnError' => true, 'targetClass' => CashDesk::class,
                'targetAttribute' => ['desk_number' => 'desk_number'], 'message' => 'Чек выдан не в нашем магазине'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
            [['date_purchase'], 'safe'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
            'date_add' => 'Дата добавления',
            'date_purchase' => 'Дата покупки',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert) AND strtotime($this->date_purchase) !== false) {
            $this->date_purchase = date('Y-m-d H:i:s', strtotime($this->date_purchase));
            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchByDate()
    {
        $query = new Query();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );

        $this->validate(['createTimeRange']);

        $query->select(['e.last_name', 'e.first_name', 'COUNT(*) c', 'SUM(IFNULL(`total`, 0)) s'])
            ->from('rate t')
            ->innerJoin('employee e', 'e.id = t.employee_id')
            ->groupBy(['e.last_name', 'e.first_name'])
            ->orderBy('c desc, s desc');
        if (!empty($this->createTimeRange)) {
            $query->andFilterWhere(['>=', 'date_purchase', date('Y-m-d', $this->createTimeStart)])
                ->andFilterWhere(['<', 'date_purchase', date('Y-m-d', $this->createTimeEnd)]);
        }
        return $dataProvider;
    }
}
