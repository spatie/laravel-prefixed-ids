<?php

return [
    /*
     * The attribute name used to store prefixed ids on a model
     */
    'prefixed_id_attribute_name' => 'prefixed_id',

    /*
     * Using prefixed id's as primary id?
     * If set to true, it's suggested to set 'prefixed_ids_attribute_name' to 'id'.
     * Setting this to true sets Model's $incrementing to false by default.
     */
    'prefixed_id_is_primary' => false,
];
