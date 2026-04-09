<?php

return [
    'navigation' => [
        'group' => 'Facturation',
    ],
    'resources' => [
        'company' => [
            'singular' => 'Société',
            'plural' => 'Sociétés',
        ],
        'customer' => [
            'singular' => 'Client',
            'plural' => 'Clients',
        ],
        'invoice' => [
            'singular' => 'Facture',
            'plural' => 'Factures',
        ],
        'quote' => [
            'singular' => 'Devis',
            'plural' => 'Devis',
        ],
        'payment' => [
            'singular' => 'Paiement',
            'plural' => 'Paiements',
        ],
        'product' => [
            'singular' => 'Produit',
            'plural' => 'Produits',
        ],
        'tax_rate' => [
            'singular' => 'Taux de TVA',
            'plural' => 'Taux de TVA',
        ],
        'invoice_series' => [
            'singular' => 'Série de facturation',
            'plural' => 'Séries de facturation',
        ],
        'credit_note' => [
            'singular' => 'Avoir',
            'plural' => 'Avoirs',
        ],
    ],
    'actions' => [
        'create' => 'Créer',
        'view' => 'Voir',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'bulk_delete' => 'Supprimer la sélection',
        'finalize' => 'Finaliser',
        'generate_share_link' => 'Générer le lien public',
        'revoke_share_link' => 'Révoquer le lien public',
        'convert_to_invoice' => 'Convertir en facture',
        'credit_note' => 'Avoir',
    ],
    'columns' => [
        'reference' => 'Référence',
        'legal_name' => 'Raison sociale',
        'company' => 'Société',
        'email' => 'Email',
        'phone' => 'Téléphone',
        'created_at' => 'Créé',
        'number' => 'Numéro',
        'customer' => 'Client',
        'status' => 'Statut',
        'type' => 'Type',
        'issued_at' => 'Émis',
        'due_at' => 'Échéance',
        'total' => 'Total',
    ],
    'statuses' => [
        'draft' => 'Brouillon',
        'pending' => 'En attente',
        'finalized' => 'Finalisée',
        'paid' => 'Payée',
        'cancelled' => 'Annulée',
        'overdue' => 'En retard',
    ],
    'messages' => [
        'invoice_finalized' => 'Facture finalisée',
        'public_share_link_ready' => 'Lien public prêt',
        'public_share_link_revoked' => 'Lien public révoqué',
        'credit_note_created' => 'Avoir créé',
        'quote_converted' => 'Devis converti en facture',
        'demo_seeded' => 'Données de démonstration créées',
    ],
];
