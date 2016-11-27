<?php
class Transaction extends ActiveRecord {

    const STATUS_REJECTED = 'rejected';
    const STATUS_APPROVED = 'approved';

    public static $rejectReasons = [
        'I don\'t like you',
        'I think I can\'t believe you',
        'I don\'t want to log your transaction',
        'You are not allowed to perform transaction',
        'Fraud detected'
    ];

    public $tableName = 'transaction';

    public $rules = [
        ['email, amount', 'required'],
        ['email, reject_reason', 'length', ['max' => 255]],
        ['email', 'email'],
        ['amount', 'numeric', ['max' => 100000, 'min' => 0.01]]
    ];

    public function __construct() {
        parent::__construct();
    }

    /**
     * @param string $className
     * @return Transaction
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function generateRandomAttributes($amount, $email) {
        $statuses = [self::STATUS_REJECTED, self::STATUS_APPROVED];
        $statusKey = array_rand($statuses);
        $status = $statuses[$statusKey];

        if($status === self::STATUS_REJECTED) {
            $key = array_rand(self::$rejectReasons);
            $reject_reason = self::$rejectReasons[$key];
        }

        $create_date = $this->getRandomCreateDate();

        return compact('amount', 'email', 'create_date', 'reject_reason', 'status');
    }


    function getRandomCreateDate() {
        $startDate = '2016-11-1';
        $min = strtotime($startDate);
        $max = time();

        $rand = rand($min, $max);

        return date('Y-m-d H:i:s',$rand);
    }
}