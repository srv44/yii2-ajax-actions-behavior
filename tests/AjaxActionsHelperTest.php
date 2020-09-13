<?php

namespace srv44\AjaxActions\tests;

use PHPUnit\Framework\TestCase;
use srv44\AjaxActions\AjaxActionsHelper;

class AjaxActionsHelperTest extends TestCase
{
    public function testAjaxResult()
    {
        self::assertEquals(['success' => true], AjaxActionsHelper::ajaxResult(true));
        self::assertEquals(['success' => true, 'test' => 'test'],
            AjaxActionsHelper::ajaxResult(true, ['test' => 'test']));
        self::assertEquals(['success' => false], AjaxActionsHelper::ajaxResult(false));
        self::assertEquals(['success' => false, 'test' => 'test'],
            AjaxActionsHelper::ajaxResult(false, ['test' => 'test']));
    }
    
    public function testAjaxSuccess()
    {
        self::assertEquals(['success' => true], AjaxActionsHelper::ajaxSuccess());
        self::assertEquals(['success' => true], AjaxActionsHelper::ajaxSuccess([]));
        self::assertEquals(['success' => true, 'test' => 'test'], AjaxActionsHelper::ajaxSuccess(['test' => 'test']));
        self::assertEquals(['success' => true], AjaxActionsHelper::ajaxSuccess(['success' => false]));
        self::assertEquals(['success' => true, 'test' => 'test'],
            AjaxActionsHelper::ajaxSuccess(['success' => false, 'test' => 'test']));
    }
    
    public function testAjaxError()
    {
        self::assertEquals(['errorMessage' => 'Error!', 'success' => false], AjaxActionsHelper::ajaxError(''));
        self::assertEquals(['errorMessage' => 'Some error!', 'success' => false],
            AjaxActionsHelper::ajaxError('Some error!'));
        
        self::assertEquals(['errorMessage' => 'Some error!', 'test' => 'test', 'success' => false],
            AjaxActionsHelper::ajaxError('Some error!', ['test' => 'test']));
        self::assertEquals(['errorMessage' => 'Some error!', 'test' => 'test', 'success' => false],
            AjaxActionsHelper::ajaxError('Some error!', ['success' => true, 'test' => 'test']));
        
        self::assertEquals(['errorMessage' => 'Some error!', 'test' => 'test', 'success' => false],
            AjaxActionsHelper::ajaxError('Some error!', ['success' => true, 'test' => 'test'], ''));
        self::assertEquals(['someErrorMessage' => 'Some error!', 'test' => 'test', 'success' => false],
            AjaxActionsHelper::ajaxError('Some error!',
                ['success' => true, 'test' => 'test'], 'someErrorMessage'));
        
    }
}