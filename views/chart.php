<?php

/**
 * show results. simple horizontal bar chart
 */

use yii\bootstrap\Progress;
use yii\helpers\Html;


?>
<div class="polls-result-show" style="background-color:white;width:400px;padding:10px;margin:10px;">

    <h3><?= Html::encode(Yii::t('polls', $question)) ?></h3>
    <h4><?= Html::encode(Yii::t('polls', "The results of the poll")) ?></h4>

    <?php

    /**
     * sort function for array
     * @param type $a
     * @param type $b
     * @return int
     */
    function cmp($a, $b)
    {
        if ($a['res'] == $b['res']) {
            return 0;
        }
        return ($a['res'] > $b['res']) ? -1 : 1;
    }

    if (!is_array($dataProvider)) {
        $model = $dataProvider->getModels();
    } else {
        $model = $dataProvider;
    }
    $res = array();


    foreach ($model as $answer) {
//        var_dump($answer);exit;
        $res[] = ['answer' => $answer->answer, 'res' => $answer->res];
    }

    if (!isset($sumRes)) {
        $sumRes = 0;
        foreach ($model as $answer) {
            $sumRes += $answer->res;
        }
    }
    /**
     * sort result in
     */
    usort($res, "cmp");

    /**
     * Max value of polls, using for showing results
     * Maximum values has maximum bar
     * @var integer $maxVal Max value of polls, using for showing results
     */
    $maxVal = intval($res[0]['res']);

    if ($sumRes > 0) {
        foreach ($res as $val) {
            echo "<h5>" . Yii::t('polls', $val['answer']) . ":  " . $val['res'] . " (" . number_format($val['res'] / $sumRes * 100, 2) . "%)" . "</h5>";
            echo yii\bootstrap\Progress::widget([
                'percent' => intval($val['res']) / $maxVal * 100,
            ]);
        }
    }
    ?>

</div>

