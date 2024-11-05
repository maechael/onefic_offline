<?php

return [
    'bsVersion' => '4.x',
    'defaultPageSize' => 10,

    'apiBaseUrl' => 'https://test.ficphil.com/v1',      // yii2 api
    'apiBaseUrl2' => 'https://d2.ficphil.com/api/v1',   // laravel api
    'testApiBaseUrl' => 'http://ficphil.local.test/v1',
    'apiBaseUrlFicTechService' => 'http://ficphil.local.test/v1',
    'base_upload_folder' => 'uploads',
    'equipment_issue_folder' => 'equipment-issues',

    'syncBlockSize' => 1024,
    'syncTransferSize' => 8,

    'onlineDsn' => 'mysql:host=184.168.103.101;', //DSN nung go daddy 
    'onlineDb' => 'onefic', //Name ng DB don sa GoDaddy
    'onlineUser' => 'onefic_admin',
    'onlinePassword' => 'fic@123',

    'localDb' => 'itdi_onefic-offline',
    'localDsn' => 'mysql:host=localhost;',
    'localUser' => 'root',
    'localPassword' => '',

    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    'sync_map' => [
        /**
         * The list of available table to be synced..
         * ..will be based here
         * '*local_table_name' => 'central_table_name'
         */

        'region' => 'region',
        'province' => 'province',
        'municipality_city' => 'municipality_city',

        'fic' => 'fic',
        'facility' => 'facility',
        'service' => 'service',
        'tech_service' => 'tech_service',

        'media' => 'metadata',

        'equipment_type' => 'equipment_type',
        'equipment_category' => 'equipment_category',
        'processing_capability' => 'processing_capability',
        'component' => 'component',
        'part' => 'part',
        'spec_key' => 'spec_key',

        'supplier' => 'supplier',
        'branch' => 'branch',
        'part_supplier' => 'part_supplier',
        'supplier_media' => 'supplier_media',

        'equipment' => 'equipment',
        'equipment_component' => 'equipment_component',
        'equipment_component_part' => 'equipment_component_part',
        'equipment_spec' => 'equipment_spec',
        'equipment_tech_service' => 'equipment_tech_service',
        'checklist_component_template' => 'checklist_component_template',
        'criteria_template' => 'criteria_template',

        'designation' => 'designation',
    ]
];
