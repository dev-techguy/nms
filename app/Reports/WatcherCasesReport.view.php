<?php

use koolreport\widgets\koolphp\Table;

Table::create([
    "dataSource" => $this->dataStore("incidents"),
    "columns" => array(
        "case_number" => array(
            "label" => "Case ID"
        ),
        "created_at" => array(
            "label" => "Date Received",
            'formatValue' => function ($value) {
                return date('Y-m-d H:i:s', strtotime($value));
            }
        ),
        "alert_mode" => array(
            "label" => "Alert Mode"
        ),
        "location",
        "sub_county" => array(
            "label" => "Sub County",
            "type" => "string",
        ),
        "alert_nature" => array(
            "label" => "Alert Nature"
        ),
        "status")
]);
