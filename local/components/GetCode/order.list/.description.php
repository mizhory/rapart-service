<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => 'getcode:list.list',
	"DESCRIPTION" => 'getcode:list.list.description',//GetMessage("T_IBLOCK_DESC_DETAIL_DESC"),
	//"ICON" => "/images/news_detail.gif",
	"SORT" => 10,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "getcode",
		"CHILD" => array(
			"ID" => "getcode",
			"NAME" => "getcode.child.name",//GetMessage("T_IBLOCK_DESC_NEWS"),
			"SORT" => 10,
		),
	),
);
