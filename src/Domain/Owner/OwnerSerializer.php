<?php

namespace App\Domain\Owner;

class OwnerSerializer
{
    public static function toJson(Owner $owner): string
    {
        return self::loadData(
            uuid: $owner->uuid()->value(),
            dni: $owner->dni()->value(),
            surname: $owner->surname(),
            name: $owner->name()
        );
    }

    public static function toJsonWithWrongUuid(Owner $owner): string
    {
        return self::loadData(
            uuid: 'af4cbe9a-f218',
            dni: $owner->dni()->value(),
            surname: $owner->surname(),
            name: $owner->name()
        );
    }

    public static function toJsonWithWrongDni(Owner $owner): string
    {
        return self::loadData(
            uuid: $owner->uuid()->value(),
            dni: 3456,
            surname: $owner->surname(),
            name: $owner->name()
        );
    }

    public static function toJsonWithEmptyParameters(Owner $owner): string
    {
        return self::loadData(
            uuid: $owner->uuid()->value(),
            dni: 3456,
            surname: '',
            name: ''
        );
    }

    private static function loadData(string $uuid, string $dni, string $surname, string $name): string
    {
        $json = '{ 
            "uuid": "%s",
            "dni": "%s",
            "surname": "%s",
            "name": "%s"
        }';

        return sprintf($json, $uuid, $dni, $surname, $name);
    }
}
