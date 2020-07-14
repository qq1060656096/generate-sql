# generate-sql

## 安装方式
> 创建composer.json文件,并写入以下内容:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/qq1060656096/generate-sql.git"
        }
    ],
    "require": {
        "zwei/generate-sql": "dev-master"
    }
}
```
> 执行composer install


```php
<?php
use Zwei\GenerateSql\Mysql\BatchUpdateSql;
$data = [
    [
        'id' => 1,
        'name' => 'andy.update.1',
        'age' => 110.6,
    ],
    [
        'id' => 2,
        'name' => 'yoki.update.2',
        'age' => 4.5,
    ],
];
$where = [
    [
        'id' => 1,
        'name' => 'andy',
        'age' => 110,
    ],
    [
        'id' => 2,
        'name' => 'yoki',
        'age' => 4,
    ],
];
$field = 'id';
$obj = new BatchUpdateSql('test', $where, $data, $field);
var_dump("\n", $obj->getSql(), $obj->getPlaceholderSql(), $obj->getPlaceholderParams());
/*
string(257) "update test set`name`=CASE id  WHEN 1 THEN 'andy.update.1' WHEN 2 THEN 'yoki.update.2' end,`age`=CASE id  WHEN 1 THEN 110.6 WHEN 2 THEN 4.5 end WHERE `name`=CASE id  WHEN 1 THEN 'andy' WHEN 2 THEN 'yoki' end,`age`=CASE id  WHEN 1 THEN 110 WHEN 2 THEN 4 end;"
string(211) "update test set`name`=CASE id  WHEN ? THEN ? WHEN ? THEN ? end,`age`=CASE id  WHEN ? THEN ? WHEN ? THEN ? end WHERE `name`=CASE id  WHEN ? THEN ? WHEN ? THEN ? end,`age`=CASE id  WHEN ? THEN ? WHEN ? THEN ? end;"
array(16) {
  [0]=>
  int(1)
  [1]=>
  string(13) "andy.update.1"
  [2]=>
  int(2)
  [3]=>
  string(13) "yoki.update.2"
  [4]=>
  int(1)
  [5]=>
  float(110.6)
  [6]=>
  int(2)
  [7]=>
  float(4.5)
  [8]=>
  int(1)
  [9]=>
  string(4) "andy"
  [10]=>
  int(2)
  [11]=>
  string(4) "yoki"
  [12]=>
  int(1)
  [13]=>
  int(110)
  [14]=>
  int(2)
  [15]=>
  int(4)
}

*/
```

```sh
php vendor/phpunit/phpunit/phpunit --bootstrap vendor/autoload.php tests
```
