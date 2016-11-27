<?php
class ReportController extends Controller
{

    public function actionTransactionSum() {
        $app = Application::getInstance();

        /**
         * @var DbConnection $db
         */

        $db = $app->db;

        $firstDayOfThisMonth =  new DateTime('first day of this month');
        $firstDayOfThisMonth->setTime(0, 0, 0);
        $date = $firstDayOfThisMonth->format('Y-m-d H:i:s');

        $sql = <<<SQL
          SELECT sum(amount) as approvedSum, email
          FROM transaction
          WHERE create_date >= :date AND status = :approved
          GROUP BY email
SQL;

        $params = [
            ':date' => $date,
            ':approved' => Transaction::STATUS_APPROVED
        ];

        $result = $db->query($sql, $params);

        if(!empty($result)) {
            $result = array_map(function($item){
                return [
                    'email' => $item['email'],
                    'sum' => $item['approvedSum']
                ];
            }, $result);
        }


        return $result;
    }

    public function actionTransactionByWeekDay() {
        $app = Application::getInstance();

        /**
         * @var DbConnection $db
         */

        $db = $app->db;

        $firstDayOfThisMonth =  new DateTime('first day of this month');
        $firstDayOfThisMonth->setTime(0, 0, 0);
        $date = $firstDayOfThisMonth->format('Y-m-d H:i:s');

        $sql = <<<SQL
          SELECT email,
          SUM(case when WEEKDAY(create_date) = 0 then amount else 0 end) as Monday,
          SUM(case when WEEKDAY(create_date) = 1 then amount else 0 end) as Tuesday,
          SUM(case when WEEKDAY(create_date) = 2 then amount else 0 end) as Wednesday,
          SUM(case when WEEKDAY(create_date) = 3 then amount else 0 end) as Thursday,
          SUM(case when WEEKDAY(create_date) = 4 then amount else 0 end) as Friday,
          SUM(case when WEEKDAY(create_date) = 5 then amount else 0 end) as Saturday,
          SUM(case when WEEKDAY(create_date) = 6 then amount else 0 end) as Sunday
          FROM transaction
          WHERE status = 'approved'
          GROUP BY email

SQL;


        $params = [
            ':date' => $date,
            ':approved' => Transaction::STATUS_APPROVED
        ];

        $result = $db->query($sql, $params);

        if(!empty($result)) {
            $result = array_map(function($item){
                return [
                    'email' => $item['email'],
                    'Monday' => $item['Monday'],
                    'Tuesday' => $item['Tuesday'],
                    'Wednesday' => $item['Wednesday'],
                    'Thursday' => $item['Thursday'],
                    'Friday' => $item['Friday'],
                    'Saturday' => $item['Saturday'],
                    'Sunday' => $item['Sunday'],
                ];
            }, $result);
        }

        return $result;
    }
}