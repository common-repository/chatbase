<?php

/**
 * Plugin Name: Chatbase
 * Plugin URI: https://www.chatbase.co
 * Description: Embed your Chatbase chatbot on any Wordpress site.
 * Version: 1.0.3
 * Author: Chatbase
 * Author URI: https://www.chatbase.co/
 * License: GPL2
 */

add_action('admin_menu', 'add_chatbase_options_page');

// Add the options page to the admin menu
function add_chatbase_options_page()
{
    add_options_page('Chatbase Plugin Settings', 'Chatbase Options', 'administrator', 'chatbase_id', 'chatbase_options_page');
    add_action('admin_init', 'register_chatbase_options');
}

// Register the options settings
function register_chatbase_options()
{
    register_setting('chatbase_options', 'chatbase_id');
}

// Define the content of the options page
function chatbase_options_page()
{
    ?>
    <div class="wrap">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                background-color: #f8f9fa;
            }

            #form-container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                /*height: 100vh;*/
            }

            .logo-container a {
                text-decoration: none;
                color: #000;
            }

            .form-group {
                margin-bottom: 0.5rem;
            }

            .note-label {
                font-weight: 600;
            }

            label.text-secondary {
                color: #6c757d;
            }

            input.form-control {
                width: 100%;
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
            }

            .submit-btn-container {
                display: flex;
                justify-content: flex-end;
            }

            .logo-container {
                display: flex;
                justify-content: center;
                margin-bottom: 1rem;
            }
        </style>

        <h1>
            <?php echo esc_html(get_admin_page_title()); ?>
        </h1>
        <div id="form-container">

            <form method="post" action="options.php">
                <?php settings_fields('chatbase_options'); ?>
                <?php do_settings_sections('chatbase_options'); ?>

                <div class="logo-container">
                    <a href="https://www.chatbase.co/" target="_blank">
                        <img alt="Chatbase" loading="lazy" width="64" style="color:transparent"
                            src="https://www.chatbase.co/images/chatbase-logo.svg">
                    </a>
                </div>

                <div class="form-group">
                    <label for="chatbase_id" class="text-secondary">Chatbot ID</label>
                    <input type="text" class="form-control" placeholder="Chatbot ID" name="chatbase_id" id="chatbase_id"
                        value="<?php echo esc_attr(get_option('chatbase_id')); ?>" required />
                </div>
                <label class="note-label">*Note: Copy your Chatbot ID from <a href="https://www.chatbase.co/"
                        target="_blank">Chatbase</a>
                    chatbot settings
                    tab.</label>
                <div class="submit-btn-container">
                    <?php submit_button(); ?>
                </div>
            </form>
        </div>



    </div>
    <?php
}

// Embed the script on the site using the ID entered in the options page
function chatbase_embed_chatbot()
{
    $handle = 'chatbot-script';

    $script_url = 'https://www.chatbase.co/embed.min.js';

    $chatbase_id = get_option('chatbase_id');

    // Enqueue the script
    wp_enqueue_script(
        $handle,
        $script_url,
        array(), // Dependencies (if any)
        null, // Version number (null for no version)
        true // Add script in the footer
    );

    // Pass data to the script
    wp_localize_script(
        $handle,
        'embeddedChatbotConfig',
        array(
            'chatbotId' => esc_attr($chatbase_id),
            'domain' => 'www.chatbase.co',
        )
    );
}

add_action('wp_enqueue_scripts', 'chatbase_embed_chatbot');
?>