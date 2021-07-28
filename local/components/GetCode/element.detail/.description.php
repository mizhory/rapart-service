<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => 'getcode:element-detail',
	"DESCRIPTION" => 'getcode:element-detail',
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
