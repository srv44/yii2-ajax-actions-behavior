<?php

namespace srv44\AjaxActions\tests;

use PHPUnit\Framework\TestCase;
use srv44\AjaxActions\AjaxActionsHelper;

class AjaxActionsHelperTest extends TestCase
{
    public function testResult()
    {
        self::assertEquals(['success' => true], AjaxActionsHelper::result(true));
        self::assertEquals(['success' => true, 'test' => 'test'],
            AjaxActionsHelper::result(true, ['test' => 'test']));
        self::assertEquals(['success' => false], AjaxActionsHelper::result(false));
        self::assertEquals(['success' => false, 'test' => 'test'],
            AjaxActionsHelper::result(false, ['test' => 'test']));
    }
    
    public function testSuccess()
    {
        self::assertEquals(['success' => true], AjaxActionsHelper::success());
        self::assertEquals(['success' => true], AjaxActionsHelper::success([]));
        self::assertEquals(['success' => true, 'test' => 'test'], AjaxActionsHelper::success(['test' => 'test']));
        self::assertEquals(['success' => true], AjaxActionsHelper::success(['success' => false]));
        self::assertEquals(['success' => true, 'test' => 'test'],
            AjaxActionsHelper::success(['success' => false, 'test' => 'test']));
    }
    
    public function testError()
    {
        self::assertEquals(['success' => false, 'errorMessage' => 'Error!'], AjaxActionsHelper::error());
        self::assertEquals(['success' => false, 'errorMessage' => 'Error!'], AjaxActionsHelper::error(''));
        self::assertEquals(['success' => false, 'errorMessage' => 'Some error!'],
            AjaxActionsHelper::error('Some error!'));
        
        self::assertEquals(['success' => false, 'errorMessage' => 'Some error!', 'test' => 'test'],
            AjaxActionsHelper::error('Some error!', ['test' => 'test']));
        self::assertEquals(['success' => false, 'errorMessage' => 'Some error!', 'test' => 'test'],
            AjaxActionsHelper::error('Some error!', ['success' => true, 'test' => 'test']));
        
        self::assertEquals(['success' => false, 'errorMessage' => 'Some error!', 'test' => 'test'],
            AjaxActionsHelper::error('Some error!', ['success' => true, 'test' => 'test'], ''));
        self::assertEquals(['success' => false, 'someErrorMessage' => 'Some error!', 'test' => 'test'],
            AjaxActionsHelper::error('Some error!',
                ['success' => true, 'test' => 'test'], 'someErrorMessage'));
        
    }
}