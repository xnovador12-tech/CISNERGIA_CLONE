<?php

return [

    'models' => [
        /*
         * Usamos nuestro propio modelo Role que extiende el de Spatie
         * para agregar los campos slug, descripcion y estado.
         */
        'permission' => Spatie\Permission\Models\Permission::class,
        'role'       => App\Models\Role::class,
    ],

    'table_names' => [
        'roles'                 => 'roles',
        'permissions'           => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles'       => 'model_has_roles',
        'role_has_permissions'  => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Columna en model_has_permissions y model_has_roles que
         * guarda el ID del modelo (User).
         */
        'role_pivot_key'       => null,
        'permission_pivot_key' => null,
        'model_morph_key'      => 'model_id',
        'team_foreign_key'     => 'team_id',
    ],

    /*
     * No usamos equipos (teams). Mantenemos en false.
     */
    'teams' => false,

    /*
     * Cache de permisos para no consultar la BD en cada request.
     * Se invalida automáticamente cuando se asignan/revocan permisos.
     */
    'cache' => [
        'expiration_time'  => \DateInterval::createFromDateString('24 hours'),
        'key'              => 'spatie.permission.cache',
        'store'            => 'default',
    ],

];
