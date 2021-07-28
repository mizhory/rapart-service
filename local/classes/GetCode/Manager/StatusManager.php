<?php
namespace GetCode\Manager;

use GetCode\Entity\StatusesTable;
//use \Bitrix\Main;

class StatusManager
{
    public static function getFileByStatusID($status_id = false) {
        if(is_bool($status_id)) return null;

        $e = StatusesTable::getList(['select' => ['*'], 'filter' => ['ID' => $status_id], 'order' => ['ID' => 'ASC']]);
        if($z=$e->fetch())
            return \CFile::GetFileArray($z['UF_STATUS_IMG']);
    }
}