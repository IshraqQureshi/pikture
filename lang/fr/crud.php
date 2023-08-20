<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Créer',
        'edit' => 'Modifier',
        'update' => 'Mise à jour',
        'new' => 'Nouvelle',
        'cancel' => 'Annuler',
        'attach' => 'Attacher',
        'detach' => 'Détacher',
        'save' => 'Sauvegarder',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer sélectionnée',
        'search' => 'Recherche...',
        'back' => 'Retour à l\'index',
        'are_you_sure' => 'Es-tu sûr?',
        'no_items_found' => 'Aucun élément trouvé',
        'created' => 'Créé avec succès',
        'saved' => 'Enregistré avec succès',
        'removed' => 'Suppression réussie',
    ],

    'users' => [
        'name' => 'Utilisatrices',
        'index_title' => 'Liste des utilisateurs',
        'new_title' => 'Nouvel utilisateur',
        'create_title' => 'Créer un utilisateur',
        'edit_title' => 'Modifier l\'utilisateur',
        'show_title' => 'Afficher l\'utilisateur',
        'inputs' => [
            'name' => 'Nom',
            'email' => 'E-mail',
            'password' => 'Mot de passe',
        ],
    ],

    'events' => [
        'name' => 'Événements',
        'index_title' => 'Liste des événements',
        'new_title' => 'Nouvel évènement',
        'create_title' => 'Créer un évènement',
        'edit_title' => 'Modifier l\'événement',
        'show_title' => 'Afficher l\'événement',
        'inputs' => [
            'gallery_name' => 'Nom de la galerie',
            'max_photos' => 'Max Photos',
            'max_users' => 'Utilisateurs maximum',
            'expiration_date' => 'Date d\'expiration',
            'user_id' => 'Utilisatrice',
        ],
    ],

    'photos' => [
        'name' => 'Photos',
        'index_title' => 'Liste des photos',
        'new_title' => 'Nouvelle photo',
        'create_title' => 'Créer une photo',
        'edit_title' => 'Modifier photo',
        'show_title' => 'Afficher la photo',
        'inputs' => [
            'event_id' => 'Événement',
            'photo' => 'Photo',
        ],
    ],

    'invitations' => [
        'name' => 'Invitations',
        'index_title' => 'Liste des invitations',
        'new_title' => 'Nouvelle invitation',
        'create_title' => 'Créer une invitation',
        'edit_title' => 'Modifier l\'invitation',
        'show_title' => 'Afficher l\'invitation',
        'qr_code' => 'QR Code',
        'inputs' => [
            'email' => 'E-mail',
            'event_id' => 'Événement',
        ],
    ],

    'comments' => [
        'name' => 'Commentaires',
        'index_title' => 'Liste des commentaires',
        'new_title' => 'Nouveau commentaire',
        'create_title' => 'Créer un commentaire',
        'edit_title' => 'Modifier le commentaire',
        'show_title' => 'Afficher le commentaire',
        'inputs' => [
            'photo_id' => 'Photo',
            'comment' => 'Commentaire',
        ],
    ],

    'roles' => [
        'name' => 'Les rôles',
        'index_title' => 'Liste des rôles',
        'create_title' => 'Créer un rôle',
        'edit_title' => 'Modifier le rôle',
        'show_title' => 'Afficher le rôle',
        'inputs' => [
            'name' => 'Nom',
        ],
    ],

    'permissions' => [
        'name' => 'Autorisations',
        'index_title' => 'Liste des autorisations',
        'create_title' => 'Créer une autorisation',
        'edit_title' => 'Modifier l\'autorisation',
        'show_title' => 'Afficher l\'autorisation',
        'inputs' => [
            'name' => 'Nom',
        ],
    ],

    'contact' => [
        'create_title' => 'Demande de contact',
        'action'        => 'Envoyer',
        'send'          => 'Merci! pour nous contacter'
    ],

    'cart' => [
        'add_to_cart' => 'Photo ajoutée au panier',
        'update_cart' => 'Panier mis à jour avec succès',
        'index_title' => 'Mon panier',
        'checkout_title'    => 'Vérifier',
        'payment_processed' => 'Commande passée avec succès',
        'no_print_option' => 'Sélectionnez Options d\'impression pour toutes les photos',
        'input' => [
            'photo' => 'Photo',
            'qty'   => 'Quantité',
            'print' => 'Options d\'impression',
            'price' => 'Prix',            
            'submit' => 'Passer la commande'
        ]
    ],
    'order' => [
        'index_title' => 'Ordres',
        'inputs'    => [
            'name'  => 'Nom',
            'email' => 'E-mail',
            'total_price' => 'Prix total de la commande',
            'city'  => 'Ville',
            'country'   => 'Pays',
            'postal_code'   => 'Code Postal',
            'phone'     => 'Téléphone',
            'address'   => 'Adresse',
            'billing'   => 'Facturation'
        ],
        'item' => [
            'photo' => 'Photo',
            'print_option' => 'Options d\'impression',
            'price' =>  'Prix',
            'quantity'  => 'Quantité',
            'total_price'   => 'Prix ​​total'
        ]
    ]

];
