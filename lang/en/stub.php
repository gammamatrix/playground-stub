<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Stub Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'Classes.properties.required' => 'Adding a class [:class] requires both a property: [:property] and an fqdn [:fqdn].',
    'Classes.properties.invalid' => 'Adding a class [:class] requires the property [:property] to exist to add the fqdn [:fqdn]',

    'Package.keywords.invalid' => 'Ignoring a keyword [:keyword] for the composer.json file.',
    'Package.require.invalid' => 'Ignoring a requirement: package [:package] with version [:version] for the composer.json file.',
    'Package.require-dev.invalid' => 'Ignoring a dev requirement: package [:package] with version [:version] for the composer.json file.',

    'Model.CreateColumn.type.unexpected' => 'Unexpected type [:type] for column [:column] - allowed: :allowed',

    'Model.Attributes.invalid' => 'Adding an attribute to [:name] requires a column [:column] to be provided.',
    'Model.Casts.invalid' => 'Adding a cast to [:name] requires a column [:column] to be provided.',
    'Model.Fillable.invalid' => 'Adding a fillable column to [:name] requires a column [:column] to be provided.',
];
