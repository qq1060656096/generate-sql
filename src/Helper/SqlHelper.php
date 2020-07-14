<?php
namespace Zwei\GenerateSql\Helper;


class SqlHelper
{
    /**
     * @param array $params
     * @return array
     */
    public static function placeholderParamsToReplaceParams(array $params)
    {
        foreach ($params as &$row) {
            if (is_array($row)) {
                $row = self::placeholderParamsToReplaceParams($params);
                continue;
            }
            if (is_string($row)) {
                $row = sprintf("'%s'", addslashes($row));
                continue;
            }
        }
        return $params;
    }
    
    
}
