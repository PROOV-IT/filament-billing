<?php

return [
    'navigation' => [
        'group' => 'Billing',
    ],
    'resources' => [
        'company' => [
            'singular' => 'Company',
            'plural' => 'Companies',
        ],
        'customer' => [
            'singular' => 'Customer',
            'plural' => 'Customers',
        ],
        'invoice' => [
            'singular' => 'Invoice',
            'plural' => 'Invoices',
        ],
        'quote' => [
            'singular' => 'Quote',
            'plural' => 'Quotes',
        ],
        'payment' => [
            'singular' => 'Payment',
            'plural' => 'Payments',
        ],
        'product' => [
            'singular' => 'Product',
            'plural' => 'Products',
        ],
        'tax_rate' => [
            'singular' => 'Tax rate',
            'plural' => 'Tax rates',
        ],
        'invoice_series' => [
            'singular' => 'Invoice series',
            'plural' => 'Invoice series',
        ],
        'credit_note' => [
            'singular' => 'Credit note',
            'plural' => 'Credit notes',
        ],
    ],
    'actions' => [
        'create' => 'Create',
        'view' => 'View',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'bulk_delete' => 'Delete selected',
        'finalize' => 'Finalize',
        'generate_share_link' => 'Generate share link',
        'revoke_share_link' => 'Revoke share link',
        'convert_to_invoice' => 'Convert to invoice',
        'credit_note' => 'Credit note',
    ],
    'columns' => [
        'reference' => 'Reference',
        'legal_name' => 'Legal name',
        'company' => 'Company',
        'email' => 'Email',
        'phone' => 'Phone',
        'created_at' => 'Created',
        'number' => 'Number',
        'customer' => 'Customer',
        'status' => 'Status',
        'type' => 'Type',
        'issued_at' => 'Issued',
        'due_at' => 'Due',
        'total' => 'Total',
    ],
    'statuses' => [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'finalized' => 'Finalized',
        'paid' => 'Paid',
        'cancelled' => 'Cancelled',
        'overdue' => 'Overdue',
    ],
    'messages' => [
        'invoice_finalized' => 'Invoice finalized',
        'public_share_link_ready' => 'Public share link ready',
        'public_share_link_revoked' => 'Public share link revoked',
        'credit_note_created' => 'Credit note created',
        'quote_converted' => 'Quote converted to invoice',
        'demo_seeded' => 'Demo data seeded',
    ],
];
