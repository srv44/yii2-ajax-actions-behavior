<?php
namespace srv44\AjaxActions;

use RuntimeException;
use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class AjaxActionsBehavior
 * @package srv44\AjaxActions
 */
class AjaxActionsBehavior extends Behavior
{
    // whether to run a check in afterAction
    public $checkResponse = true;
    
    /**
     * @inheritdoc
     */
    public function events()
    {
        $events = [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
        
        if ($this->checkResponse) {
            $events[Controller::EVENT_AFTER_ACTION] = 'afterAction';
        }
        
        return $events;
    }
    
    /**
     * @param ActionEvent $event
     */
    public function beforeAction($event)
    {
        if (preg_match('/^ajax-.+$/', $event->action->id) > 0) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
    }
    
    /**
     * @param ActionEvent $event
     */
    public function afterAction($event)
    {
        $result = $event->result;
        
        if (!is_array($result)) {
            throw new RuntimeException('Bad response format! Returned value must be array.');
        }
        
        if (!isset($result['success'])) {
            throw new RuntimeException('Bad response format! "success" field required!');
        }
    }
}