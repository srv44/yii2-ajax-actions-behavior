<?php

namespace srv44\AjaxActions\tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Yii;
use yii\base\Action;
use yii\web\Application;
use yii\web\Controller;
use yii\base\ActionEvent;
use yii\web\Response;
use srv44\AjaxActions\AjaxActionsBehavior;

class AjaxActionsBehaviorTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }
    
    protected function tearDown()
    {
        $this->destroyApplication();
        parent::tearDown();
    }
    
    protected function mockApplication()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        new Application([
            'id' => 'test',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
        ]);
    }
    
    protected function destroyApplication()
    {
        Yii::$app = null;
    }
    
    public function testBeforeAction()
    {
        $controller = new Controller('id', Yii::$app);
        $action = new Action('test', $controller);
        $event = new ActionEvent($action);
        
        $behavior = new AjaxActionsBehavior();
        $behavior->beforeAction($event);
        self::assertNotSame(Yii::$app->response->format, Response::FORMAT_JSON);
        
        $action = new Action('ajax-test', $controller);
        $event = new ActionEvent($action);
        $behavior->beforeAction($event);
        self::assertSame(Yii::$app->response->format, Response::FORMAT_JSON);
    }
    
    public function testAfterAction()
    {
        $controller = new Controller('id', Yii::$app);
        $action = new Action('test', $controller);
        $event = new ActionEvent($action);
        $event->result = 'test';
        
        $behavior = new AjaxActionsBehavior();
        try {
            $behavior->afterAction($event);
            self::fail('Expected Exception');
        } catch (Exception $e) {
            self::assertSame('Bad response format! Returned value must be array.', $e->getMessage());
        }
        
        $event->result = ['foo' => 'bar'];
        try {
            $behavior->afterAction($event);
        } catch (Exception $e) {
            self::assertSame('Bad response format! "success" field required!', $e->getMessage());
        }
        
        $event->result = ['success' => false, 'errorMsg' => ''];
        $behavior->afterAction($event);
        $event->result = ['success' => false, 'errorMsg' => '', 'test' => 'test'];
        $behavior->afterAction($event);
        $event->result = ['success' => false, 'someErrorMsg' => '', 'test' => 'test'];
        $behavior->afterAction($event);
        $event->result = ['success' => true];
        $behavior->afterAction($event);
        $event->result = ['success' => true, 'test' => 'test'];
        $behavior->afterAction($event);
    }
    
    public function testEvents()
    {
        $behavior = new AjaxActionsBehavior();
        self::assertEquals([Controller::EVENT_BEFORE_ACTION => 'beforeAction', Controller::EVENT_AFTER_ACTION => 'afterAction'],
            $behavior->events());
        $behavior = new AjaxActionsBehavior(['checkResponse' => false]);
        self::assertEquals([Controller::EVENT_BEFORE_ACTION => 'beforeAction'], $behavior->events());
    }
}