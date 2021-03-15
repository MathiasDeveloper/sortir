<?php

namespace DemoBundle\Enum;

abstract class StateTypeEnum
{
    const TYPE_CREATED = 'CREATED';
    const TYPE_OPENED = 'OPENED';
    const TYPE_CLOSED = 'CLOSED';
    const TYPE_ONGOING = 'ONGOING';
    const TYPE_ENDED = 'ENDED';
    const TYPE_CANCELED = 'CANCELED';

    /** @var array user friendly named type */
    protected static $typeName = [
        self::TYPE_CREATED     => 'Créée',
        self::TYPE_OPENED      => 'Ouverte',
        self::TYPE_CLOSED      => 'Clôturée',
        self::TYPE_ONGOING     => 'Activité en cours',
        self::TYPE_ENDED       => 'passée',
        self::TYPE_CANCELED    => 'Annulée',
    ];

    /**
     * @param string $typeShortName
     *
     * @return string
     */
    public static function getTypeName($typeShortName)
    {
        if (! isset(static::$typeName[$typeShortName])) {
            return "Unknown type ($typeShortName)";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_CREATED,
            self::TYPE_OPENED,
            self::TYPE_CLOSED,
            self::TYPE_ONGOING,
            self::TYPE_ENDED,
            self::TYPE_CANCELED,
        ];
    }
}
