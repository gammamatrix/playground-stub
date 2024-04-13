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

    'Configuration.addClassTo.property.required' => 'Adding a class [:class] requires both a property: [INVALID: :property] and an fqdn [:fqdn].',
    'Configuration.addClassTo.fqdn.required' => 'Adding a class [:class] requires both a property: [:property] and an fqdn [INVALID: :fqdn].',
    'Configuration.addClassTo.property.missing' => 'Adding a class [:class] requires the property to exist [MISSING: :property] to exist to add the fqdn [:fqdn]',

    'Configuration.addClassFileTo.property.required' => 'Adding a class [:class] requires both a property: [INVALID: :property] and a file [:file].',
    'Configuration.addClassFileTo.file.required' => 'Adding a class [:class] requires both a property: [:property] and a file [INVALID: :file].',
    'Configuration.addClassFileTo.property.missing' => 'Adding a class [:class] requires the property [MISSING: :property] to exist to add a file [:file]',

    'Configuration.addMappedClassTo.property.required' => 'Adding a class [:class] requires a property: [INVALID: :property], a key: [:key] and an value [:value].',
    'Configuration.addMappedClassTo.key.required' => 'Adding a mapped class [:class] requires a property: [:property], a key: [INVALID: :key] and a value [:value].',
    'Configuration.addMappedClassTo.value.required' => 'Adding a mapped class [:class] requires a property: [:property], a key: [:key] and a value [INVALID: :value].',
    'Configuration.addMappedClassTo.property.missing' => 'Adding a mapped class [:class] requires the property to exist: [MISSING: :property], a key: [:key] and a value [:value].',

    'Configuration.addToUse.class.required' => 'Adding a use class [:class] requires a valid class: [INVALID: :use_class] and an optional key [:key].',

    'Package.keywords.invalid' => 'Ignoring a keyword [:keyword] for the composer.json file.',
    'Package.require.invalid' => 'Ignoring a requirement: package [:package] with version [:version] for the composer.json file.',
    'Package.require-dev.invalid' => 'Ignoring a dev requirement: package [:package] with version [:version] for the composer.json file.',

    'Model.CreateColumn.type.unexpected' => 'Unexpected type [:type] for column [:column] - allowed: :allowed',

    'Model.Attributes.invalid' => 'Adding an attribute to [:name] requires a column [:column] to be provided.',
    'Model.Casts.invalid' => 'Adding a cast to [:name] requires a column [:column] to be provided.',
    'Model.Fillable.invalid' => 'Adding a fillable column to [:name] requires a column [:column] to be provided.',

    'Model.HasOne.invalid' => 'Adding a HasOne to [:name] requires an accessor [:accessor] to be provided.',
    'Model.HasMany.invalid' => 'Adding a HasMany to [:name] requires an accessor [:accessor] to be provided.',

    'Model.Scope.invalid' => 'Adding a Scope to [:name] requires a scope [:scope] to be provided.',
    'Model.Scope.ignored' => 'Adding a Scope to [:name] is limited to [sort] at this time.',

    'Model.Sorting.invalid' => 'Adding a sortable column to [:name] requires a column [:column] to be provided - index[:i]',
];