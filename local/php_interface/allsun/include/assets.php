<?php
/**
 * @about AllSun-Integration 2021 - Copyright AllRight Reserved
 * @author Kokurkin-German
 */
use \Bitrix\Main\Page\Asset;

\CJSCore::Init(
    array(
        "main",
        'jquery3',
        'ajax',
        'popup',
        'ui',
        'drag_drop',
        'masked_input',
        'sidepanel',
        'phone_number'
    )
);
Asset::getInstance()->addJs("/local/assets/js/core.js");
Asset::getInstance()->addCss("/local/assets/css/core.css");