<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'events' => [
        'name' => 'Events',
        'index_title' => 'Events List',
        'new_title' => 'New Event',
        'create_title' => 'Create Event',
        'edit_title' => 'Edit Event',
        'show_title' => 'Show Event',
        'inputs' => [
            'gallery_name' => 'Gallery Name',
            'max_photos' => 'Max Photos',
            'max_users' => 'Max Users',
            'expiration_date' => 'Expiration Date',
            'user_id' => 'User',
        ],
    ],

    'photos' => [
        'name' => 'Photos',
        'index_title' => 'Photos List',
        'new_title' => 'New Photo',
        'create_title' => 'Create Photo',
        'edit_title' => 'Edit Photo',
        'show_title' => 'Show Photo',
        'inputs' => [
            'event_id' => 'Event',
            'photo' => 'Photo',
        ],
    ],

    'invitations' => [
        'name' => 'Invitations',
        'index_title' => 'Invitations List',
        'new_title' => 'New Invitation',
        'create_title' => 'Create Invitation',
        'edit_title' => 'Edit Invitation',
        'show_title' => 'Show Invitation',
        'qr_code' => 'QR Code',
        'inputs' => [
            'email' => 'Email',
            'event_id' => 'Event',
        ],
    ],

    'comments' => [
        'name' => 'Comments',
        'index_title' => 'Comments List',
        'new_title' => 'New Comment',
        'create_title' => 'Create Comment',
        'edit_title' => 'Edit Comment',
        'show_title' => 'Show Comment',
        'inputs' => [
            'photo_id' => 'Photo',
            'comment' => 'Comment',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'contact' => [
        'create_title' => 'Contact Inquiry',
        'action'        => 'Send',
        'send'          => 'Thankyou! for contacting us'
    ],

    'cart' => [
        'add_to_cart' => 'Photo added to cart',
        'update_cart' => 'Cart updated sucessfully',
        'index_title' => 'My Cart',
        'checkout_title' => 'Checkout',
        'payment_processed' => 'Order sucessfully placed',
        'no_print_option' => 'Select Print Options for all photos',
        'input' => [
            'photo' => 'Photo',
            'qty'   => 'Quantity',
            'print' => 'Print Option',
            'price' => 'Price',       
            'submit' => 'Place Order'     
        ]
    ],
    'order' => [
        'index_title' => 'Orders',
        'inputs'    => [
            'name'  => 'Name',
            'email' => 'Email',
            'total_price' => 'Total Order Price',
            'city'  => 'City',
            'country'   => 'Country',
            'postal_code'   => 'Postal Code',
            'phone'     => 'Phone',
            'address'   => 'Address',
            'billing'   => 'Billing',
            'sub_total' => 'Sub Total',
            'shipping'  => 'Shipping'
        ],
        'item' => [
            'photo' => 'Photo',
            'print_option' => 'Print Option',
            'price' =>  'Price',
            'quantity'  => 'Quantity',
            'total_price'   => 'Total Price'
        ]
    ],
    'print_option' => [
        'index_title' => 'Print Options',
        'create_title'  => 'Add New Print Option',
        'edit_title'    => 'Edit Print Option',
        'inputs' => [
            'print_type'    => 'Print Type',
            'paper_type'    => 'Paper Type',
            'packaging'     => 'Packaging',
            'price'         => 'Price'
        ]
    ],
    'shipping' => [
        'index_title' => 'Shipping',
        'create_title'  => 'Add New Shipping',
        'edit_title'    => 'Edit Shipping',
        'inputs' => [
            'name'    => 'Shipping Name',
            'price'    => 'Price',
        ]
    ]

];
