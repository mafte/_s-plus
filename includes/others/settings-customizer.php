<?php

// get value with get_theme_mod()

function my_register_additional_customizer_settings($wp_customize) {

    /*  |> Example for text field
    ——————————————————————————————————————————————————————*/
    $wp_customize->add_setting(
        'my_company_name',
        array(
            'default' => '',
            'type' => 'theme_mod', // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'my_company_name',
        array(
            'label'      => __('Company name', 'textdomain'),
            'description' => __('Description for your field', 'textdomain'),
            'settings'   => 'my_company_name',
            'priority'   => 10,
            'section'    => 'title_tagline',
            'type'       => 'text',
        )
    ));

    /*  |> Example for image field
    ——————————————————————————————————————————————————————*/
    $wp_customize->add_setting(
        'logo_version_two',
        array(
            'default' => '',
            'type' => 'theme_mod', // you can also use 'option'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control(new WP_Customize_Media_Control(
        $wp_customize,
        'logo_version_two',
        array(
            'label' => __('Logo version 2', '_s_plus'),
            'section' => 'title_tagline',
            'mime_type' => 'image',
            'settings'   => 'logo_version_two',

        )
    ));
}
add_action('customize_register', 'my_register_additional_customizer_settings');
