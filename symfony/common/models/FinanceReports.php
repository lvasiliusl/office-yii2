<?php
namespace common\models;

use yii\base\Model;
use common\models\OfficeBalance;
use common\models\BalanceTransactions;

/**
 * Finance Reports Model
 */
class FinanceReports extends Model
{

    /**
    * @inheritdoc
    */
    public function officeBalancesReports()
    {
        $modelOfficeBalances = OfficeBalance::find()->asArray()->all();

        foreach ($modelOfficeBalances as $key => $value) {
            $qwe[$value['name']] = BalanceTransactions::find()->asArray()->where([
                'balance' => $value['id']
                ])->all();
        }

        var_dump($qwe);die;

        return $modelOfficeBalances;
    }
}
