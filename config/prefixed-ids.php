<?php

return [
    /*
     * The attribute name used to store prefixed ids on a model
     */
    'prefixed_id_attribute_name' => 'prefixed_id',

    /*
     * By default UUID's will be used. Setting this to true will use ordered UUID's instead.
     */
    'should_use_ordered_uuid' => false,

    /*
     * Using prefixed ids as primary id?
     * If set to true, set 'prefixed_ids_attribute_name' to 'id'
     * Setting this to true sets $incrementing to false by default.
     * You can publish stubs 'php artisan prefixedids:stubs' to automatically update migrations/model creation
     */
    'prefixed_id_is_primary' => false,
];
