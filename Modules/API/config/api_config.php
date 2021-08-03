<?php

return [

    /**
     * AUTHORIZATION , API KEY
     */
    'auth_api_key' => 'Eq3HVUZnazE4NA69DgOcitZeCQywvdOFRgZyuGFcrhyQsS2Ao51jfgp3hQgDv1GziuelBMUi514Xm4f6DZazTbeLSH2JXqeHTvOYLxZy1l419pfiRDn9lRU61wRw2PL',


    /**
     * GET , Get Orders
     */
    'get_orders_endpoint' => 'https://sample-market.despatchcloud.uk/api/orders',


    /**
     * GET , Get Order Details
     * ID is required
     */
    'get_order_details_endpoint' => 'https://sample-market.despatchcloud.uk/api/orders/',


    /**
     * PUT , change Order Status
     */
    'change_order_status_endpoint' => 'https://sample-market.despatchcloud.uk/api/orders/',

    /**
     * HTTP timeout
     */
    'http_timeout' => '5',

    /**
     * max request per minutes
     */
    'rate_limit' => '30',

    /**
     * sleep time in second after exceeded the rate limit time
     */
    'sleep_time' => '2',

];
