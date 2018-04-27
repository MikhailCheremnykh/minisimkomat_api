<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


// Start result state
$result = ["status" => 1,
           "result" => ["error_code" => 0,
                        "error_message" => "Empty response"
           ]
];



// Wait only POST-requests
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Check field 'params'
    if (isset($_POST["params"])) {

        // Try to decode input JSON
        $requestJson = json_decode($_POST["params"]);

        /* If error decode JSON */
        if (isset($requestJson)) {

            // Check 'terminal_id' field
            if (isset($requestJson->terminal_id)) {

                // Check 'action' field
                if (isset($requestJson->action)) {

                    // 'action' == "checkcode"
                    if ($requestJson->action == "checkcode") {

                        // Check 'code' field
                        if (isset($requestJson->code)) {

                            // hardcode
                            if (in_array($requestJson->code, ["d58e3582afa99040e27b92b13c8f2280", "aa7bd407c50f95fe54fc500c6e7193b4", "d58e3582afa99040e27b92b13c8f2280"])) {

	                            // Success result
        	                    $result = ["status" => 0,
                	                       "result" => "ok"	];


                            } else {

                                // Error 16
                                $result = ["status" => 1,
                                    "result" => ["error_code" => 16,
                                        "error_message" => "Wrong code"
                                    ]
                                ];


                            }

                        } else {

                            // Error 15
                            $result = ["status" => 1,
                                        "result" => ["error_code" => 15,
                                                    "error_message" => "No 'code' in input JSON for action 'checkcode'"
                                        ]
                            ];

                        }

                    }

                    elseif ($requestJson->action == "card") {

                        // Check 'iccid' field
                        if (isset($requestJson->iccid)) {

                            // Success result
                            $result = ["status" => 0,
                                "result" => "ok" ];

                        }

                        else {

                            // Error 18
                            $result = ["status" => 1,
                                "result" => ["error_code" => 18,
                                    "error_message" => "No 'iccid' in input JSON for action 'card'"
                                ]
                            ];

                        }

                    }


                    else {

                        // Error 17
                        $result = ["status" => 1,
                            "result" => ["error_code" => 17,
                                "error_message" => "Unknown 'action' in input JSON"
                            ]
                        ];



                    }





                } else {

                    // Error 14
                    $result = ["status" => 1,
                        "result" => ["error_code" => 14,
                            "error_message" => "No 'action' in input JSON"
                        ]
                    ];
                }
            } else {

                // Error 13
                $result = ["status" => 1,
                    "result" => ["error_code" => 13,
                        "error_message" => "No 'terminal_id' in input JSON"
                    ]
                ];
            }

        } else {

            // Error 12
            $result = ["status" => 1,
                        "result" => ["error_code" => 12,
                                     "error_message" => "Incorrect JSON in field 'params'"
                        ]
            ];

        }
    }

    else {

        // Error no required field
        $result = ["status" => 1,
                   "result" => ["error_code" => 11,
                                "error_message" => "Field 'params' is require"
                    ]
        ];

    }

} else {

    // Error 10
    $result = ["status" => 1,
               "result" => ["error_code" => 10,
                            "error_message" => "Wrong request. You must send POST-request"
               ]
    ];
}


// Return result
echo json_encode($result);


?>