<?php

namespace Axioma\Db\DataType;

use Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\Type;

/**
 * Тип данных для маппинга полей datetime в экземпляры Axioma\Date
 */
class RichDate extends Type {
    const TYPE_NAME = 'richdate';
    const TYPE_NAME_SQL = 'datetime';

    public function getName() {
        return self::TYPE_NAME;
    }

    /**
     * Преобразование даты в формат СУБД
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if ($value instanceof \Axioma\Date)
            $value = $value->get(\Axioma\Date::W3C);
        return $value;
    }

    /**
     * Маппинг даты из формата СУБД в экземпляр Axioma\Date
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if ($value)
            $value = new \Axioma\Date($value);
        return $value;
    }

    /**
     * Тип, который СУБД будет использовать для хранения даты
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return self::TYPE_NAME_SQL;
    }
}