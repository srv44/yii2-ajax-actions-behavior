<?php
namespace srv44\AjaxActions;

/**
 * Class AjaxActionsHelper
 * @package srv44\AjaxActions
 */
class AjaxActionsHelper
{
    /**
     * @param bool $success
     * @param array $params
     * @return array
     */
    public static function result($success, $params = [])
    {
        unset($params['success']);
        return array_merge(['success' => $success], $params);
    }
    
    /**
     * @param string $errorMsg
     * @param array $params
     * @param string $errorMsgKey
     * @return array
     */
    public static function error($errorMsg = 'Error!', $params = [], $errorMsgKey = 'errorMessage')
    {
        return self::result(false, array_merge($params, [(!empty($errorMsgKey) ? $errorMsgKey : 'errorMessage') => !empty($errorMsg) ? $errorMsg : 'Error!']));
    }
    
    /**
     * @param array $params
     * @return array
     */
    public static function success($params = [])
    {
        return self::result(true, $params);
    }
}