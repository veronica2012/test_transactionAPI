<?php

class TransactionController extends Controller
{

    public function actionIndex() {
        $app = Application::getInstance();
        $request = $app->getRequest();

        $raw = $request->getRawBody();

        if(!empty($raw)) {

            $body = json_decode($raw);
            $email = isset($body->email) ? $body->email : null;
            $amount = isset($body->amount) ? $body->amount : null;

        }else {

            $email = $request->getParam('email');
            $amount = $request->getParam('amount');
        }


        $fakeAttributes = Transaction::model()->generateRandomAttributes($amount, $email);

        $model = new Transaction();
        $model->setAttributes($fakeAttributes);

        $result = $model->save();
        $response = Application::getInstance()->getResponse();

        if($result === true) {
            $response->setStatusCode(201);
            if($model->status == Transaction::STATUS_REJECTED) {
                return ['result' => 'false', 'errors' => [$model->reject_reason]];
            }

            return true;
        }

        $response->setStatusCode(304);

        return ['result' => 'false', 'errors' => $model->getErrors()];
    }
}