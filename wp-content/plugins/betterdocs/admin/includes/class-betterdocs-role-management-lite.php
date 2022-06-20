<?php

/**
 * Role Management Class Lite
 */
class Betterdocs_Role_Management_Lite {
    /**
     * Default Roles Capabilities
     *
     * @var array
     */
    public static $default_capabilities = [
        'administrator' => [
            'edit_docs',
            'edit_others_docs',
            'delete_docs',
            'publish_docs',
            'read_private_docs',
            'delete_private_docs',
            'delete_published_docs',
            'delete_others_docs',
            'edit_private_docs',
            'edit_published_docs',
            'manage_doc_terms',
            'edit_doc_terms',
            'delete_doc_terms',
            'manage_knowledge_base_terms',
            'edit_knowledge_base_terms',
            'delete_knowledge_base_terms',
            'edit_docs_settings',
            'read_docs_analytics',
        ],
        'editor' => [
            'edit_docs',
            'edit_others_docs',
            'publish_docs',
            'edit_published_docs',
            'edit_private_docs',
            'read_private_docs',
            'delete_published_docs',
            'delete_private_docs',
            'delete_docs',
            'delete_others_docs',
            'manage_doc_terms',
            'edit_doc_terms',
            'delete_doc_terms',
            'manage_knowledge_base_terms',
            'edit_knowledge_base_terms',
            'delete_knowledge_base_terms'
        ],
        'author' => [
            'edit_docs',
            'edit_published_docs',
            'publish_docs',
            'delete_docs',
            'delete_published_docs'
        ],
        'contributor' => [
            'edit_docs',
            'delete_docs'
        ],
        'other_roles' => [
            'edit_docs',
            'delete_docs',
        ]
    ];

    /**
     * Run The Constructor When Class Is Initialized
     *
     * @since 2.0.7
     */
    public function __construct() {
        // $this->betterdocs_capabilities_migrator(); // FIXME: need to test
        $this->actions();
    }
    /**
     * Contains Action Hook Callback Methods
     *
     * @since 2.0.7
     * @return void
     */
    public function actions() {
        add_action('admin_init', [$this, 'add_admin_caps']);
    }

    public function add_admin_caps(){
        $assigned = get_option('_betterdocs_caps_assigned', false);

        if( ! empty( self::$default_capabilities ) && ! $assigned ) {
            foreach( self::$default_capabilities as $role => $caps ) {
                $role_object = get_role( $role );
                if( $role_object instanceof \WP_Role ) {
                    foreach( $caps as $cap ) {
                        $role_object->add_cap( $cap );
                    }
                }
            }

            update_option('_betterdocs_caps_assigned', '1.0.0');
        }
    }

    /**
     * Betterdocs Capabilities Migrator Method
     *
     * @since 2.0.7
     * @return void
     */
    public function betterdocs_capabilities_migrator() {
        if( get_option( 'betterdocs_rm_version', false ) === false ) {
            $settings       = BetterDocs_DB::get_settings();
            $existing_roles = BetterDocs_Settings::get_role_cap_mapper( $settings );
            foreach( $existing_roles as $key => $values ) {
                $roles = ( $values['roles'] == 'off' ) ? array('administrator') : $values['roles'];
                if( ! empty( $roles ) ) {
                    foreach( $roles as $role ) {
                        $role_object = get_role( $role );
                        if( is_null( $role_object ) || ! $role_object instanceof \WP_Role ) {
                            continue;
                        }
                        if( $key == 'write_docs' ) {
                            $role_default_caps = ! empty( $this->default_capabilities[$role] ) ? $this->default_capabilities[$role] : $this->default_capabilities['other_roles'];
                            foreach( $role_default_caps as $cap ) {
                                $role_object->add_cap( $cap );
                            }
                        } else {
                            $role_object->add_cap( $key );
                        }
                    }
                }
            }
            update_option( 'betterdocs_rm_version', '1.0' );
        }
    }
}