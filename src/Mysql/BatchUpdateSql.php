<?php
namespace Zwei\GenerateSql\Mysql;


use Zwei\GenerateSql\Helper\SqlHelper;
use Zwei\GenerateSql\SqlAbstract;

class BatchUpdateSql extends SqlAbstract
{
    protected $where = [];
    protected $data = [];
    protected $field = '';
    
    /**
     * BatchUpdateSql constructor.
     * @param string $tableName
     * @param array $where
     * @param array $data
     * @param string $field
     */
    public function __construct($tableName, array $where, array $data, $field)
    {
        /*
        $data = [
            [
                'id' => 1,
                'clicks' => 2,
                'type' => 3,
            ],
            [
                'id' => 2,
                'clicks' => 22,
                'type' => 33,
            ],
        ];
        $where = [
            [
                'id' => 1,
                'clicks' => 20,
                'type' => 30,
            ],
            [
                'id' => 2,
                'clicks' => 220,
                'type' => 330,
            ],
        ];
        $this->field = 'id';
        */
        $this->tableName = $tableName;
        $this->where = $where;
        $this->data = $data;
        $this->field = $field;
    }
    
    /**
     * @inheritDoc
     */
    public function compile()
    {
        $this->isCompile = true;
        $this->placeholderSql = "update {$this->tableName} set";
        list($sql, $params) = $this->getPlaceholderCaseSetThen($this->data);
        $this->placeholderSql = $this->placeholderSql.$sql;
        $this->placeholderParams = array_merge($this->placeholderParams, $params);
        if (!empty($this->where)) {
            list($sql, $params) = $this->getPlaceholderCaseWhenThen($this->where);
            $this->placeholderSql = $this->placeholderSql.' WHERE '.$sql.';';
            $this->placeholderParams = array_merge($this->placeholderParams, $params);
        }
        $this->sql = $this->placeholderSql;
        $this->sql = str_replace('?', "%s", $this->sql);
        $this->sql = sprintf($this->sql, ...SqlHelper::placeholderParamsToReplaceParams($this->getPlaceholderParams()));
    }
    
    /**
     * @param array $data
     * @return array
     */
    public function getCaseWhenThen(array $data)
    {
        $data = array_values($data);
        $fieldValues = array_column($data, $this->field);
        $caseArr = [];
        foreach ($data as $index => $row) {
            foreach ($row as $key2Field => $rowValue) {
                if ($key2Field == $this->field) {
                    continue;
                }
            
                if (!isset($caseArr[$key2Field])) {
                    $caseArr[$key2Field]['placeholderTemplate'] = "CASE {$this->field} ";
                    $caseArr[$key2Field]['placeholderParams'] = [];
                }
                $caseArr[$key2Field] = [
                    'placeholderTemplate' => $caseArr[$key2Field]['placeholderTemplate'].sprintf(" WHEN %s THEN %s", '?', '?'),
                    'placeholderParams' => array_merge($caseArr[$key2Field]['placeholderParams'], [$fieldValues[$index], $rowValue]),
                ];
            }
        }
        return $caseArr;
    }
    
    /**
     * @param array $data
     * @return array [$placeholderSql, $placeholderParams]
     */
    public function getPlaceholderCaseWhenThen(array $data)
    {
        $caseArr = $this->getCaseWhenThen($data);
        $arr = [];
        $placeholderParams = [];
        foreach ($caseArr as $field => $row) {
            $arr[] = sprintf("`{$field}`=%s end", $row['placeholderTemplate']);
            $placeholderParams = array_merge($placeholderParams, $row['placeholderParams']);
        }
        $placeholderSql = implode(',', $arr);
        return [$placeholderSql, $placeholderParams];
    }
    
    /**
     * @param array $data
     * @return array [$placeholderSql, $placeholderParams]
     */
    public function getPlaceholderCaseSetThen(array $data)
    {
        $caseArr = $this->getCaseWhenThen($data);
        $arr = [];
        $placeholderParams = [];
        foreach ($caseArr as $field => $row) {
            $arr[] = sprintf("`{$field}`=%s end", $row['placeholderTemplate']);
            $placeholderParams = array_merge($placeholderParams, $row['placeholderParams']);
        }
        $placeholderSql = implode(',', $arr);
        return [$placeholderSql, $placeholderParams];
    }
}

