<?php

class GlobalsConst
{

    // Config
    const DB_NAME = 'order_gen';
    const DB_HOST = 'db_1';
    const DB_USER = 'root';
    const DB_PASSWORD = 'root';
    // Modes types
    const MODE_MANUAL = 'Manual';
    const MODE_AUTO = 'Auto';
    // Status types
    const STATUS_ALL_ORDERS = 'All orders';
    const STATUS_PENDING = 'Pending';
    const STATUS_IN_PROGRESS = 'In progress';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_CANCELED = 'Canceled';
    const STATUS_ERROR = 'Error';
    // Search types
    const SEARCH_ORDER_ID = 1;
    const SEARCH_LINK = 2;
    const SEARCH_USER = 3;
}
