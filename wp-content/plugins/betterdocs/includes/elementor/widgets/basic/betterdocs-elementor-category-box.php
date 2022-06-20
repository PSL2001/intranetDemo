<?php

use Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Category_Box extends Widget_Base
{

    use \Better_Docs_Elementor\Traits\Template_Query;

    public function get_name()
    {
        return 'betterdocs-category-box';
    }

    public function get_title()
    {
        return __('BetterDocs Category Box', 'betterdocs');
    }

    public function get_icon()
    {
        return 'betterdocs-icon-category-box';
    }

    public function get_categories()
    {
        return ['docs-archive', 'betterdocs-elements'];
    }

    public function get_style_depends()
    {
        return [
            'betterdocs-category-box'
        ];
    }

    public function get_keywords()
    {
        return [
            'knowledgebase',
            'knowledge Base',
            'documentation',
            'doc',
            'kb',
            'betterdocs',
            'docs',
            'category-box'
        ];
    }

    public function get_custom_help_url()
    {
        return 'https://betterdocs.co/docs/betterdocs-category-box';
    }

    protected function register_controls()
    {
        /**
         * Query  Controls!
         * @source includes/elementor-helper.php
         */
        do_action('betterdocs/elementor/widgets/query', $this, 'doc_category');

        /**
         * ----------------------------------------------------------
         * Section: Layout Options
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_layout_options',
            [
                'label' => __('Layout Options', 'betterdocs')
            ]
        );

        $this->add_control(
            'layout_template',
            [
                'label'       => __('Select Layout', 'betterdocs'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->template_options(),
                'default'     => $this->get_default(),
                'label_block' => true
            ]
        );

        $this->add_responsive_control(
            'box_column',
            [
                'label'              => __('Box Column', 'betterdocs'),
                'type'               => Controls_Manager::SELECT,
                'default'            => '3',
                'tablet_default'     => '2',
                'mobile_default'     => '1',
                'options'            => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ],
                'prefix_class'       => 'elementor-grid%s-',
                'frontend_available' => true,
                'label_block'        => true,
                'condition' => [
                    'layout_template' => ['layout-2', 'default']
                ]
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label'        => __('Show Icon', 'betterdocs'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'betterdocs'),
                'label_off'    => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'        => __('Show Title', 'betterdocs'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'betterdocs'),
                'label_off'    => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => __('Select Tag', 'betterdocs'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h2',
                'options'   => [
                    'h1'   => __('H1', 'betterdocs'),
                    'h2'   => __('H2', 'betterdocs'),
                    'h3'   => __('H3', 'betterdocs'),
                    'h4'   => __('H4', 'betterdocs'),
                    'h5'   => __('H5', 'betterdocs'),
                    'h6'   => __('H6', 'betterdocs'),
                    'span' => __('Span', 'betterdocs'),
                    'p'    => __('P', 'betterdocs'),
                    'div'  => __('Div', 'betterdocs'),
                ],
                'condition' => [
                    'show_title' => 'true'
                ],
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label'        => __('Show Count', 'betterdocs'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'betterdocs'),
                'label_off'    => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default'      => 'true'
            ]
        );

        $this->add_control(
            'listview-show-description',
            [
                'label'        => __('Show Category Description', 'betterdocs'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'betterdocs'),
                'label_off'    => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default'      => 'true',
                'condition' => [
                    'layout_template' => 'layout-3'
                ]
            ]
        );

        $this->add_control(
            'count_prefix',
            [
                'label'     => __('Prefix', 'betterdocs'),
                'type'      => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'condition' => [
                    'show_count' => 'true',
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_control(
            'count_suffix',
            [
                'label'     => __('Suffix', 'betterdocs'),
                'type'      => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'   => __('articles', 'betterdocs'),
                'condition' => [
                    'show_count' => 'true',
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_control(
            'count_suffix_singular',
            [
                'label'     => __('Suffix Singular', 'betterdocs'),
                'type'      => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'   => __('article', 'betterdocs'),
                'condition' => [
                    'show_count' => 'true',
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * ----------------------------------------------------------
         * Section: Box Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_card_settings',
            [
                'label' => __('Box', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_template' => [
                        'layout-2',
                        'default'
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'column_space', // Legacy control id but new control
            [
                'label'      => __('Box Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'column_padding',
            [
                'label'      => __('Box Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('card_settings_tabs');

        // Normal State Tab
        $this->start_controls_tab(
            'card_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg_normal',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border_normal',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner'
            ]
        );

        $this->add_responsive_control(
            'card_border_radius_normal',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow_normal',
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner'
            ]
        );

        $this->end_controls_tab();

        //Add Border Bottom Normal State
        $this->add_control(
            'category_box_border_bottom',
            [
                'label'         => __('Border Bottom', 'betterdocs'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Show', 'betterdocs'),
                'label_off'     => __('Hide', 'betterdocs'),
                'return_value'  => 'true',
                'default'       => 'false',
                'condition' => [
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_control(
            'category_box_border_bottom_size',
            [
                'label'       => __('Border Bottom Size', 'betterdocs'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  =>  ['px', 'em'],
                'range'      => [
                    'px' => [
						'min' => 0,
						'max' => 1000,
					]
                ],
                'default'    => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'condition' => [
                    'category_box_border_bottom' => 'true',
                    'layout_template' => 'default'
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner' => 'border-bottom:{{SIZE}}{{UNIT}} solid #880380D4;',
                ]
            ]
        );

        $this->add_control(
            'category_box_border_color',
            [
                'label'     => __('Border Bottom Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'default'   => ' #880380D4',
                'condition' => [
                    'category_box_border_bottom' => 'true',
                    'layout_template' => 'default'
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner' => 'border-bottom-color:{{VALUE}};',
                ]
            ]
        );

        // Hover State Tab
        $this->start_controls_tab(
            'card_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'card_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner' => 'transition: {{SIZE}}ms;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover'
            ]
        );

        $this->add_responsive_control(
            'card_border_radius_hover',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow_hover',
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover'
            ]
        );

        //Add Border Bottom On Hover
        $this->add_control(
            'category_box_border_bottom_hover',
            [
                'label'         => __('Border Bottom Hover', 'betterdocs'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Show', 'betterdocs'),
                'label_off'     => __('Hide', 'betterdocs'),
                'return_value'  => 'true',
                'default'       => 'false',
                'condition' => [
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_control(
            'category_box_border_bottom_size_hover',
            [
                'label'       => __('Border Bottom Size Hover', 'betterdocs'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  =>  ['px', 'em'],
                'range'      => [
                    'px' => [
						'min' => 0,
						'max' => 1000,
					]
                ],
                'default'    => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'condition' => [
                    'category_box_border_bottom_hover' => 'true',
                    'layout_template' => 'default'
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover' => 'border-bottom:{{SIZE}}{{UNIT}} solid #880380D4;',
                ]
            ]
        );

        $this->add_control(
            'category_box_border_color_hover',
            [
                'label'     => esc_html__('Border Color Hover', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'category_box_border_bottom_hover' => 'true',
                    'layout_template' => 'default'
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover' => 'border-bottom-color:{{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section(); # end of 'Card Settings'

        /**
         * ----------------------------------------------------------
         * Section: Icon Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_box_icon_style',
            [
                'label' => __('Icon', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_template' => [
                        'layout-2',
                        'default'
                    ]
                ]
            ]
        );

        $this->add_control(
            'category_settings_area',
            [
                'label' => __('Area', 'betterdocs'),
                'type' =>   Controls_Manager::HEADING
            ]
        );

        $this->add_responsive_control(
            'category_settings_icon_area_size_normal',
            [
                'label'      => esc_html__('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon__layout-2'    => 'flex-basis: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'category_settings_icon',
            [
                'label' => __('Icon', 'betterdocs'),
                'type' =>   Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'category_settings_icon_size_normal',
            [
                'label'      => esc_html__('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon__layout-2 img'    => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->start_controls_tabs('box_icon_styles_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'icon_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background_normal',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon, {{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon__layout-2',
                'exclude'  => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'icon_border_normal',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon, {{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon__layout-2'
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius_normal',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label'              => esc_html__('Padding', 'betterdocs'),
                'type'               => Controls_Manager::DIMENSIONS,
                'size_units'         => ['px', 'em', '%'],
                'selectors'          => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'              => esc_html__('Spacing', 'betterdocs'),
                'type'               => Controls_Manager::DIMENSIONS,
                'size_units'         => ['px', 'em', '%'],
                'allowed_dimensions' => [
                    'top',
                    'bottom'
                ],
                'selectors'          => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon' => 'margin: {{TOP}}{{UNIT}} auto {{BOTTOM}}{{UNIT}} auto;'
                ],
                'condition' => [
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'icon_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-icon,
                {{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-icon__layout-2'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'icon_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-icon,
                {{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-icon__layout-2'
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius_hover',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template' => 'default'
                ]
            ]
        );

        $this->add_control(
            'category_settings_icon_size_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .el-betterdocs-cb-cat-icon'     => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .el-betterdocs-cb-cat-icon img' => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon__layout-2'    => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-icon__layout-2 img'    => 'transition: {{SIZE}}ms;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Icon Styles'


        /**
         * ----------------------------------------------------------
         * Section: Title Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_box_title_styles',
            [
                'label' => __('Title', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_template' => [
                        'layout-2',
                        'default'
                    ]
                ]
            ]
        );

        $this->add_control(
            'title_styles_area_heading',
            [
                'label' => __('Area', 'betterdocs'),
                'type' =>   Controls_Manager::HEADING,
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_area_size',
            [
                'label'      => esc_html__('Area Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-title__layout-2'    => 'flex-basis: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cat_title_typography_normal',
                'selector' => '{{WRAPPER}} .el-betterdocs-cb-inner .el-betterdocs-cb-cat-title, {{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-title__layout-2'
            ]
        );

        $this->add_responsive_control(
            'title_alignment',
            [
                'label' => __('Text Alignment', 'betterdocs'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'betterdocs'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'betterdocs'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'betterdocs'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-title__layout-2' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ],
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('box_title_styles_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'title_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'cat_title_color_normal',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cb-inner .el-betterdocs-cb-cat-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-title__layout-2' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-cb-inner .el-betterdocs-cb-cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-title__layout-2 span'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'title_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'cat_title_color_hover',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-title__layout-2' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'category_title_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-cb-inner .el-betterdocs-cb-cat-title' => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-title__layout-2'   => 'transition: {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Icon Styles'

        /**
         * ----------------------------------------------------------
         * Section: Count Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_box_count_styles',
            [
                'label' => __('Count', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_template' => [
                        'layout-2',
                        'default'
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'count_typography_normal',
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .el-betterdocs-cb-cat-count, {{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2'
            ]
        );

        $this->add_responsive_control(
            'count_area_size',
            [
                'label'      => esc_html__('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-count__layout-2'    => 'flex-basis: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'count_box_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2',
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->start_controls_tabs('box_count_styles_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'count_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'count_color_normal',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .el-betterdocs-cb-cat-count' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'count_box_border',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2',
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_responsive_control(
            'count_box_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'count_box_box_shadow',
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2',
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_responsive_control(
            'count_box_size',
            [
                'label'      => esc_html__('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .count-inner__layout-2'    => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_responsive_control(
            'count_spacing',
            [
                'label'      => __('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner .el-betterdocs-cb-cat-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_template!'   => 'Layout_2'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'count_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'count_color_hover',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .el-betterdocs-cb-cat-count' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .count-inner__layout-2'    => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'count_box_bg_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .count-inner__layout-2',
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'count_box_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .count-inner__layout-2',
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_responsive_control(
            'count_box_border_radius_hover',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .count-inner__layout-2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'count_box_box_shadow_hover',
                'selector' => '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-inner:hover .count-inner__layout-2',
                'condition' => [
                    'layout_template'   => 'Layout_2'
                ]
            ]
        );

        $this->add_control(
            'category_count_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-betterdocs-category-box-post .el-betterdocs-cb-cat-count' => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .layout__2 .el-betterdocs-cb-cat-count__layout-2 .count-inner__layout-2' => 'transition: {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Count Styles'

        /**
         * Layout 3 Controls (List View Category)
         */
        $this->box_setting_style();
        $this->icon_setting_style();
        $this->category_title_style();
        $this->category_article_count();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'bd_category_box_wrapper',
            [
                'id'    => 'el-betterdocs-cat-box-' . esc_attr($this->get_id()),
                'class' => [
                    'el-betterdocs-category-box-wrapper',
                ],
            ]
        );

        $this->add_render_attribute(
            'bd_category_box_inner',
            [
                'class' => [
                    'el-betterdocs-category-box'
                ]
            ]
        );

        $terms_object = array(
            'taxonomy' => 'doc_category',
            'order'    => $settings['order'],
            'offset'   => $settings['offset'],
            'number'   => $settings['box_per_page'],
        );

        if ($settings['nested_subcategory'] == true) {
            $terms_object['parent'] = 0;
        }

        if ($settings['include']) {
            $terms_object['include'] = array_diff($settings['include'], (array) $settings['exclude']);
        }

        if ($settings['exclude']) {
            $terms_object['exclude'] = $settings['exclude'];
        }

        if ($settings['orderby'] == 'betterdocs_order') {
            $terms_object['meta_key'] = 'doc_category_order';
            $terms_object['orderby'] = 'meta_value_num';
            $terms_object['order'] = 'ASC';
        } else {
            $terms_object['orderby'] = $settings['orderby'];
        }


        $default_multiple_kb = BetterDocs_Elementor::get_betterdocs_multiple_kb_status();

        if ($settings['layout_template'] == 'Layout_2') {
            $settings['layout_template'] = 'layout-2';
        }
        if ($default_multiple_kb) {
            $object = get_queried_object();
            if (empty($settings['selected_knowledge_base']) && is_tax('knowledge_base')) {
                $meta_value = $object->slug;
            } else {
                $meta_value = $settings['selected_knowledge_base'];
            }

            $terms_object['meta_query'] =  array(
                array(
                    'relation' => 'OR',
                    array(
                        'key'       => 'doc_category_knowledge_base',
                        'value'     => $meta_value,
                        'compare'   => 'LIKE'
                    )
                ),
            );

            $taxonomy_objects = get_terms( apply_filters( 'betterdocs_category_terms_object', $terms_object ) );

            $html  = '<div ' . $this->get_render_attribute_string('bd_category_box_wrapper') . '>';
            $html .= '<div ' . $this->get_render_attribute_string('bd_category_box_inner') . '>';

            if( $settings['layout_template'] === 'layout-3' ) {
                $html = '';
                $html .=  '<div class="betterdocs-archive-list-view"><div class="betterdocs-categories-wrap betterdocs-category-box betterdocs-category-box-pro pro-layout-3 layout-flex betterdocs-list-view ash-bg">';
            }

            if (file_exists($this->get_template($settings['layout_template'])))
            {
                if ($taxonomy_objects && !is_wp_error($taxonomy_objects))
                {
                    foreach ($taxonomy_objects as $term)
                    {
                        $term_id = $term->term_id;
                        $term_slug = $term->slug;
                        $count = $term->count;
                        $get_term_count = betterdocs_get_postcount($count, $term_id, $settings['nested_subcategory']);
                        $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term_id, $term_slug, $count, $settings['nested_subcategory']);
                        if ($term_count > 0) {
                            $html .= BetterDocs_Elementor::include_with_variable($this->get_template($settings['layout_template']), ['term' => $term, 'term_count' => $term_count, 'settings' => $settings, 'default_multiple_kb' => $default_multiple_kb]);
                        }
                    }
                } else {
                    $html .= '<p class="no-posts-found">' . __('No posts found!', 'betterdocs') . '</p>';
                }
                wp_reset_postdata();
            } else {
                $html .= '<h4>' . __('File Not Found', 'betterdocs') . '</h4>';
            }
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        } else {
            $taxonomy_objects = get_terms( apply_filters( 'betterdocs_category_terms_object', $terms_object ) );

            $html = '<div ' . $this->get_render_attribute_string('bd_category_box_wrapper') . '>';
            $html .= '<div ' . $this->get_render_attribute_string('bd_category_box_inner') . '>';

            if( $settings['layout_template'] === 'layout-3' ) {
                $html = '';
                $html .=  '<div class="betterdocs-archive-list-view"><div class="betterdocs-categories-wrap betterdocs-category-box betterdocs-category-box-pro pro-layout-3 layout-flex betterdocs-list-view ash-bg single-kb">';
            }

            if (file_exists($this->get_template($settings['layout_template'])))
            {
                if ($taxonomy_objects && !is_wp_error($taxonomy_objects))
                {
                    foreach ($taxonomy_objects as $term)
                    {
                        $term_id = $term->term_id;
                        $term_slug = $term->slug;
                        $count = $term->count;
                        $get_term_count = betterdocs_get_postcount($count, $term_id, $settings['nested_subcategory']);
                        $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term_id, $term_slug, $count, $settings['nested_subcategory']);
                        if ($term_count > 0) {
                            $html .= BetterDocs_Elementor::include_with_variable($this->get_template($settings['layout_template']), ['term' => $term, 'term_count' => $term_count, 'settings' => $settings, 'default_multiple_kb' => $default_multiple_kb]);
                        }
                    }
                } else {
                    $html .= '<p class="no-posts-found">' . __('No posts found!', 'betterdocs') . '</p>';
                }
                wp_reset_postdata();
            } else {
                $html .= '<h4>' . __('File Not Found', 'betterdocs') . '</h4>';
            }

            $html .= '</div>';
            $html .= '</div>';

            echo $html;
        }
    }

    public function box_setting_style() {
        /**
         * ----------------------------------------------------------
         * Section: Box Styles
         * ----------------------------------------------------------
         */
         $this->start_controls_section(
             'listview_box_secion',
             [
                 'label' => __('Category Box', 'betterdocs'),
                 'tab'   => Controls_Manager::TAB_STYLE,
                 'condition' => [
                    'layout_template' => 'layout-3'
                ]
             ]
         );
 
 
         $this->start_controls_tabs('box_background_color_tabs');
 
         /** Normal State Tab Start **/
         $this->start_controls_tab(
            'box_background_color_normal',
            [
                'label' => esc_html__('Normal', 'betterdocs')
            ]
         );
 
         $this->add_responsive_control(
             'listview_wholebox_margin_normal',
             [
                 'label'      => __('Box Margin', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_responsive_control(
             'listview_wholebox_padding_normal',
             [
                 'label'      => __('Box Padding', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_control(
             'box_background_color_normal_heading',
             [
                 'label'     => __('Background Color', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Background::get_type(),
             [
                 'name'     => 'box_background_color_1',
                 'types'    => [ 'classic', 'gradient', 'video' ],
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap'
             ]
         );
 
         $this->add_control(
             'box_border_color_normal_heading',
             [
                 'label'     => __('Box Border', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'box_border_normal',
                 'label' => __( 'Border', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'box_shadow_normal',
                 'label' => __( 'Box Shadow', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap'
             ]
         );
 
 
         $this->add_control(
             'inner_boxes_normal_heading',
             [
                 'label'     => __('Category Box', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_responsive_control(
             'listview_inner_boxes_margin_normal',
             [
                 'label'      => __('Box Margin', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_responsive_control(
             'listview_inner_boxes_padding_normal',
             [
                 'label'      => __('Box Padding', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'all_box_border_normal',
                 'label' => __( 'All Boxes Border', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap'
             ]
         );
 
         $this->add_control(
            'all_box_background_color_normal',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-single-cat-wrap' => 'background-color: {{VALUE}};',
                ]
            ]
        );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'all_box_shadow_normal',
                 'label' => __( 'Box Shadow', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap'
             ]
         );
 
         $this->end_controls_tab();
         /** Normal State Tab End **/
 
         /** Hover State Tab Start **/
         $this->start_controls_tab(
             'box_background_color_hover',
             [
                  'label' => esc_html__('Hover', 'betterdocs')
             ]
         );
 
         $this->add_responsive_control(
             'listview_wholebox_margin_hover',
             [
                 'label'      => __('Box Margin', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_responsive_control(
             'listview_wholebox_padding_hover',
             [
                 'label'      => __('Box Padding', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_control(
             'box_background_color_hover_heading',
             [
                 'label'     => __('Background Color Hover', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Background::get_type(),
             [
                 'name'     => 'box_background_color_2',
                 'types'    => [ 'classic', 'gradient'],
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap:hover'
             ]
         );
 
         $this->add_control(
             'box_border_color_hover_heading',
             [
                 'label'     => __('Box Border Hover', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'box_border_hover',
                 'label' => __( 'Border', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap:hover'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'box_shadow_hover',
                 'label' => __( 'Box Shadow Hover', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap:hover'
             ]
         );
         $this->add_control(
             'cat_boxes_hover_heading',
             [
                 'label'     => __('Category Box Hover', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_responsive_control(
             'listview_inner_boxes_margin_hover',
             [
                 'label'      => __('Box Margin', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->add_responsive_control(
             'listview_inner_boxes_padding_hover',
             [
                 'label'      => __('Box Padding', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'all_box_border_hover',
                 'label' => __( 'All Boxes Border', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap:hover'
             ]
         );
 
         $this->add_control(
            'all_box_background_color_hover',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-single-cat-wrap:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'all_box_shadow_hover',
                 'label' => __( 'Box Shadow Hover', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap:hover'
             ]
         );
         $this->end_controls_tab();
         /** Hover State Tab End **/
 
         $this->end_controls_tabs();
         $this->end_controls_section();
 
    }
 
    public function icon_setting_style() {
         /**
          * ----------------------------------------------------------
          * Section: Icon Styles
          * ----------------------------------------------------------
          */
         $this->start_controls_section(
             'cat_boxes_icon_style',
             [
                 'label' => __('Category Icon', 'betterdocs'),
                 'tab'   => Controls_Manager::TAB_STYLE,
                 'condition' => [
                    'layout_template' => 'layout-3'
                ]
             ]
         );
 
         $this->add_responsive_control(
             'cat_boxes_icon_height',
             [
                 'label'      => esc_html__('Height', 'betterdocs'),
                 'type'       => Controls_Manager::SLIDER,
                 'size_units' => ['px', '%', 'em'],
                 'range'      => [
                     'px' => [
                         'max' => 500,
                     ],
                 ],
                 'selectors'  => [
                     '{{WRAPPER}} .docs-single-cat-wrap img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                 ]
             ]
         );
 
         $this->start_controls_tabs('cat_boxes_icon_tabs');
 
         /** Normal State Tab Start **/
         $this->start_controls_tab(
             'cat_boxes_icon_normal',
             ['label' => esc_html__('Normal', 'betterdocs')]
         );
 
         $this->add_control(
             'cat_boxes_icon_bc_heading',
             [
                 'label'     => __('Icon Background Color', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Background::get_type(),
             [
                 'name'     => 'box_icon_background_colors',
                 'types'    => [ 'classic', 'gradient'],
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap img',
                 'exclude'  => [
                     'image'
                 ]
             ]
         );
 
         $this->add_control(
             'cat_boxes_icon_border_heading',
             [
                 'label'     => __('Icon Border', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'cat_boxes_icon_border',
                 'label' => __( 'Border', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap img'
             ]
         );
 
         $this->add_responsive_control(
             'icon_border_radius_normal_layout_3',
             [
                 'label'      => esc_html__('Icon Border Radius', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', 'em', '%'],
                 'selectors'  => [
                     '{{WRAPPER}} .docs-single-cat-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                 ]
             ]
         );
 
         $this->end_controls_tab();
         /** Normal State Tab End **/
 
         /** Hover State Tab Start **/
         $this->start_controls_tab(
             'cat_boxes_icon_hover',
             [
                'label' => esc_html__('Hover', 'betterdocs')
             ]
         );
 
         $this->add_control(
             'cat_boxes_icon_bc_hover_heading',
             [
                 'label'     => __('Icon Background Hover Color', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Background::get_type(),
             [
                 'name'     => 'box_icon_background_colors_hover',
                 'types'    => [ 'classic', 'gradient'],
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap img:hover',
                 'exclude'  => [
                     'image'
                 ]
             ]
         );
 
         $this->add_control(
             'cat_boxes_icon_border_heading_hover',
             [
                 'label'     => __('Icon Border Hover', 'betterdocs'),
                 'type'      => Controls_Manager::HEADING,
                 'separator' => 'before'
             ]
         );
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'cat_boxes_icon_border_hover',
                 'label' => __( 'Border', 'betterdocs' ),
                 'selector' => '{{WRAPPER}} .docs-single-cat-wrap img:hover'
             ]
         );
 
 
         $this->add_responsive_control(
             'cat_boxes_icon_border_radius_hover',
             [
                 'label'      => esc_html__('Icon Border Radius', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', 'em', '%'],
                 'selectors'  => [
                     '{{WRAPPER}} .docs-single-cat-wrap img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                 ]
             ]
         );
 
         /** Hover State Tab End **/
         $this->end_controls_tabs();
         $this->end_controls_section();
 
    }
 
    public function category_title_style() {
         /**
          * ----------------------------------------------------------
          * Section: Category Title Styles
          * ----------------------------------------------------------
          */
         $this->start_controls_section(
             'cat_boxes_title_style',
             [
                 'label' => __('Category Title', 'betterdocs'),
                 'tab'   => Controls_Manager::TAB_STYLE,
                 'condition' => [
                    'layout_template' => 'layout-3'
                ]
             ]
         );
 
         $this->start_controls_tabs('cat_boxes_title_icon_tabs');
 
         /** Normal State Tab Start **/
         $this->start_controls_tab(
             'cat_boxes_title_icon_normal',
             [
                 'label' => esc_html__('Normal', 'betterdocs')
             ]
         );
 
         $this->add_control(
             'cat_boxes_title_color',
             [
                 'label'     => esc_html__('Category Title Color', 'betterdocs'),
                 'type'      => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .title-count .docs-cat-title' => 'color: {{VALUE}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'     => 'cat_boxes_title_typo_normal',
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .title-count .docs-cat-title'
             ]
         );
 
         $this->add_responsive_control(
             'cat_boxes_title_spacing_normal',
             [
                 'label'      => __('Title Spacing', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .title-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
         $this->end_controls_tab();
         /** Normal State Tab End **/ 
 
         /** Hover State Tab Start **/
         $this->start_controls_tab(
             'cat_boxes_title_icon_hover',
             [
                 'label' => esc_html__('Hover', 'betterdocs')
             ]
         );
 
         $this->add_control(
             'cat_boxes_title_color_hover',
             [
                 'label'     => esc_html__('Category Title Hover Color', 'betterdocs'),
                 'type'      => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .title-count .docs-cat-title:hover' => 'color: {{VALUE}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'     => 'cat_boxes_title_typo_normal_hover',
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .title-count .docs-cat-title:hover'
             ]
         );
 
         $this->add_responsive_control(
             'cat_boxes_title_spacing_hover',
             [
                 'label'      => __('Title Spacing Hover', 'betterdocs'),
                 'type'       => Controls_Manager::DIMENSIONS,
                 'size_units' => ['px', '%', 'em'],
                 'selectors'  => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .title-count:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ]
             ]
         );
 
 
         $this->end_controls_tab();
         /** Hover State Tab End **/ 
 
         $this->end_controls_tabs();
         $this->end_controls_section();
    }
 
    public function category_article_count(){
         /**
          * ----------------------------------------------------------
          * Section: Category Articles Styles
          * ----------------------------------------------------------
          */
         $this->start_controls_section(
             'cat_boxes_articles_style',
             [
                 'label' => __('Category Article', 'betterdocs'),
                 'tab'   => Controls_Manager::TAB_STYLE,
                 'condition' => [
                    'layout_template' => 'layout-3'
                ]
             ]
         );
 
         $this->start_controls_tabs('cat_articles_tabs');
 
         /** Normal State Tab Start **/
         $this->start_controls_tab(
             'cat_articles_normal',
             [
                 'label' => esc_html__('Normal', 'betterdocs')
             ]
         );
 
           $this->add_control(
             'cat_boxes_articles_color',
             [
                 'label'     => esc_html__('Category Article Color', 'betterdocs'),
                 'type'      => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .title-count span' => 'color: {{VALUE}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'     => 'cat_boxex_articles_typo_normal',
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .title-count span'
             ]
         );
 
         $this->add_control(
             'cat_boxex_articles_show_desc_color_normal',
             [
                 'label'     => esc_html__('Description Color', 'betterdocs'),
                 'type'      => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .title-count .cat-description' => 'color: {{VALUE}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'     => 'cat_boxex_articles_show_desc_typo_normal',
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .title-count .cat-description',
             ]
         );
 
         $this->end_controls_tab();
         /** Normal State Tab End **/
 
          /** Hover State Tab Start **/
          $this->start_controls_tab(
             'cat_articles_hover',
             [
                'label' => esc_html__('Hover', 'betterdocs')
             ]
         );
 
           $this->add_control(
             'cat_boxes_articles_color_hover',
             [
                 'label'     => esc_html__('Category Article Hover Color', 'betterdocs'),
                 'type'      => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .title-count span:hover' => 'color: {{VALUE}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'     => 'cat_boxex_articles_typo_hover',
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .title-count span:hover'
             ]
         );
 
         $this->add_control(
             'cat_boxex_articles_show_desc_color_hover',
             [
                 'label'     => esc_html__('Description Color', 'betterdocs'),
                 'type'      => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .betterdocs-categories-wrap .title-count .cat-description:hover' => 'color: {{VALUE}};',
                 ]
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name'     => 'cat_boxex_articles_show_desc_typo_hover',
                 'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .title-count .cat-description:hover'
             ]
         );
 
         $this->end_controls_tab();
         /** Hover State Tab End **/
         
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
