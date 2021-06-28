<?php
namespace GetCode\Manager;

use GetCode\Helper\SoapConfigEntry,
    \Bitrix\Main\Config\Option;

class SoapConfigManager
{
    /**
     * Объект одиночки храниться в статичном поле класса. Это поле — массив, так
     * как мы позволим нашему Одиночке иметь подклассы. Все элементы этого
     * массива будут экземплярами кокретных подклассов Одиночки. Не волнуйтесь,
     * мы вот-вот познакомимся с тем, как это работает.
     */
    private static $instances = [];
    public $soap_config = false;
    /**
     * Конструктор Одиночки всегда должен быть скрытым, чтобы предотвратить
     * создание объекта через оператор new.
     */
    protected function __construct() { }
    /**
     * Одиночки не должны быть клонируемыми.
     */
    protected function __clone() { }
    /**
     * Одиночки не должны быть восстанавливаемыми из строк.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    /**
     * Это статический метод, управляющий доступом к экземпляру одиночки. При
     * первом запуске, он создаёт экземпляр одиночки и помещает его в
     * статическое поле. При последующих запусках, он возвращает клиенту объект,
     * хранящийся в статическом поле.
     *
     * Эта реализация позволяет вам расширять класс Одиночки, сохраняя повсюду
     * только один экземпляр каждого подкласса.
     */
    public static function getInstance(): SoapConfigManager
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
    /**
     * @param $entry - key return configuration parameters
     * @return mixed parameter by configuration on soap
     */
    public function getConfigSoap($entry)
    {
        if(is_bool($this->soap_config) && !$this->soap_config)
            $this->getConfigSoapOnBitrix();

        if(key_exists($entry, $this->soap_config))
            return $this->soap_config[$entry];
        else return false;
    }

    public function getConfigSoapOnBitrix() {
        global $APPLICATION;

        $this->soap_config[SoapConfigEntry::LOGIN] = Option::get("main", SoapConfigEntry::LOGIN);
        $this->soap_config[SoapConfigEntry::URI] = Option::get("main", SoapConfigEntry::URI);
        $this->soap_config[SoapConfigEntry::PASS] = Option::get("main", SoapConfigEntry::PASS);

        if(is_null($this->soap_config[SoapConfigEntry::URI]) || is_bool($this->soap_config[SoapConfigEntry::URI]) || strlen($this->soap_config[SoapConfigEntry::URI])<=0)
            $APPLICATION->ThrowException('Soap Connection URI not found on Bitrix! Fatal Error!');
        if(is_null($this->soap_config[SoapConfigEntry::PASS]) || is_bool($this->soap_config[SoapConfigEntry::PASS]) || strlen($this->soap_config[SoapConfigEntry::PASS])<=0)
            $APPLICATION->ThrowException('Soap Connection PASS not found on Bitrix! Fatal Error!');
        if(is_null($this->soap_config[SoapConfigEntry::LOGIN]) || is_bool($this->soap_config[SoapConfigEntry::LOGIN]) || strlen($this->soap_config[SoapConfigEntry::LOGIN])<=0)
            $APPLICATION->ThrowException('Soap Connection URI not found on Bitrix! Fatal Error!');
    }
}