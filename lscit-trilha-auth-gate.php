<?php
/**
 * Plugin Name: LSCIT Cyber - Proteção da Área da Trilha & Estilo Cyber
 * Plugin URI: https://www.lscit.cloud
 * Description: Restringe o acesso às páginas da Trilha Challenge 1NF053C e seus sub-módulos apenas para usuários autenticados, e carrega automaticamente os estilos visuais LSCIT Cyber.
 * Version: 2.4.0
 * Author: LSCIT Cyber
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Redireciona usuários não logados que tentam acessar páginas restritas
 */
function lscit_protect_trilha_pages() {
    $protected_slugs = array(
        'trilha-challenge-1nf053c',
        'modulo-1',
        'modulo-2',
        'modulo-3'
    );

    if (is_page($protected_slugs)) {
        if (!is_user_logged_in()) {
            $redirect_url = wp_login_url(get_permalink());
            wp_redirect($redirect_url);
            exit;
        }
    }
}
add_action('template_redirect', 'lscit_protect_trilha_pages');

/**
 * Carrega automaticamente os estilos visuais LSCIT Cyber no front-end
 */
function lscit_enqueue_cyber_styles() {
    $css_file = plugin_dir_path(__FILE__) . 'lscit-cyber-theme.css';
    if (file_exists($css_file)) {
        wp_enqueue_style(
            'lscit-cyber-theme',
            plugin_dir_url(__FILE__) . 'lscit-cyber-theme.css',
            array(),
            filemtime($css_file)
        );
    }
}
add_action('wp_enqueue_scripts', 'lscit_enqueue_cyber_styles');

