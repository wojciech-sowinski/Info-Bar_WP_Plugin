<?php
/** 
*Plugin Name: pasek-informacyjny
*Plugin URI: https://owliedev.pl/
*Description: Wyświetlanie komunikatu na stronie w formie paska.
*Version: 1.1
*License: GPL-2.0+
*Author: Wojciech Sowiński
*Author URI: https://owliedev.pl/
**/

//add plugin to page
add_action('wp_body_open','info_bar_display');

function info_bar_display()
{    
    
    if (get_option('wjcp_info_bar_active_field') == "on" && !isset($_COOKIE['info_bar_show']) == 1 && !expirationTimeCheck()){
        ?>
                        <div onclick="setCookieAndHide()" id="info-bar-wrapper" class="info-bar-wrapper">
                            <header>
                                <span class="info-bar-header"> <?php echo get_option('wjcp_info_bar_header_field'); ?> </span>
                            </header>
                            <main>
                                <p class="info-bar-content">
                                    <?php echo get_option('wjcp_info_bar_field'); ?>
                                </p>
                            </main>
                            
                            <script>
                                    function setCookieAndHide() {
                                        const element = document.getElementById("info-bar-wrapper")                                        
                                      
                                         var date= new Date();
                                         date.setTime(date.getTime() + (24*60*60*1000));
                                         var expires = date.toGMTString();

                                        document.cookie = "info_bar_show=hidden; expires="+expires;
                                        element.remove();
                                    }
                            </script>   
                            
                        </div>    
                        <?php 
                       
                      
                }
                
                
                
            };
          
            
function info_bar_plugin_page()
{
    $page_title = 'Pasek informacyjny';
    $menu_title = 'Pasek info';
    $capatibily = 'manage_options';
    $slug = 'info-bar';
    $callback = 'info_bar_plugin_page_html';
    $icon = 'dashicons-info-outline';
    $position = 60;

    add_menu_page($page_title, $menu_title, $capatibily, $slug, $callback, $icon, $position);

    
}   ;

add_action('admin_menu','info_bar_plugin_page');

function info_bar_delete_settings(){
    delete_option('wjcp_info_bar_header_field');
    delete_option('wjcp_info_bar_field');
    delete_option('wjcp_info_bar_active_field');
    delete_option('wjcp_info-bar-text-color');
    delete_option('wjcp_info-bar-background-color');
    delete_option('wjcp_info-bar-position','center');
    delete_option('wjcp_info_bar_end_date');
};

register_deactivation_hook(__FILE__,'info_bar_delete_settings');

function info_bar_add_settings(){
    add_option('wjcp_info_bar_header_field');
    add_option('wjcp_info_bar_field');
    add_option('wjcp_info_bar_active_field');
    add_option('wjcp_info-bar-text-color','#262626');
    add_option('wjcp_info-bar-background-color','#ffcb0f');
    add_option('wjcp_info-bar-position','center');
    add_option('wjcp_info_bar_end_date');
};

register_activation_hook(__FILE__,'info_bar_add_settings');

function info_bar_register_settings(){
    register_setting('info_bar_option_group','wjcp_info_bar_header_field');
    register_setting('info_bar_option_group','wjcp_info_bar_field');
    register_setting('info_bar_option_group','wjcp_info_bar_active_field');
    register_setting('info_bar_option_group','wjcp_info-bar-text-color');
    register_setting('info_bar_option_group','wjcp_info-bar-background-color');
    register_setting('info_bar_option_group','wjcp_info-bar-position');
    register_setting('info_bar_option_group','wjcp_info_bar_end_date');
};

add_action('admin_init','info_bar_register_settings');

function expirationTimeCheck(){
   $optDate = date_create(get_option('wjcp_info_bar_end_date'));
   $optDateSec = date_timestamp_get($optDate);
   $currDateSec = current_time('timestamp');

   if($optDateSec < $currDateSec){
        update_option('wjcp_info_bar_active_field','');
        return true;
   }else {
       return false;
   }
}

function info_bar_plugin_page_html(){ ?>
    <div class="info-bar-option-page-wrapper">
    <header>
        <span class="info-bar-head-title">Pasek info</span><a href="http://owliedev.pl/"><img class="info-bar-head-owlie-logo-img" src="<?php echo plugin_dir_url( __FILE__ ) .'\img\owliedev_l.png' ?>" alt="owliedev logo"></a>
    </header>
    <form method="post" action="options.php">
		<?php settings_errors() ?>
		<?php settings_fields('info_bar_option_group'); ?>
        <div>
            <label for="info-bar-active-checkbox">Aktywny: </label>
                <input name="wjcp_info_bar_active_field" id="info-bar-active-checkbox" type="checkbox" <?php 
                    if (get_option('wjcp_info_bar_active_field') == "on"){
                        echo "checked";
                    }else {
                        echo "";
                    }           
                
                 ?>>
        </div>
        <div>
            <?php 
            if(expirationTimeCheck()){
               echo '<span class="info-bar-option-warning">Uwaga data zakończenia jest wcześniejsza niż aktualna data. Pasek jest nieaktywny.</span>';
            }
            
            ?>
            
        </div>
        
        <div>
            <label for="wjcp_info_bar_end_date" >Data zakończenia: </label>
            <input type="datetime-local" id="wjcp_info_bar_end_date" name="wjcp_info_bar_end_date" value="<?php echo get_option('wjcp_info_bar_end_date'); ?>">
        </div>
        <div>
            <label for="topbar_field_eat">Nagłówek: </label>
            <input name="wjcp_info_bar_header_field" id="topbar_field_eat"  type="text" cols="50" value=" <?php echo get_option('wjcp_info_bar_header_field'); ?> ">
        </div>
        <div>
        <label for="topbar_field_eat_text">Treść komunikatu: </label>
            <textarea name="wjcp_info_bar_field" id="topbar_field_eat_text" type="text" rows="4" cols="50"><?php echo get_option('wjcp_info_bar_field'); ?> </textarea>
        </div>
        <div>
            <label  for="info-bar-text-color-picker" >Kolor tekstu: </label>
            <input name="wjcp_info-bar-text-color" id="info-bar-text-color-picker" type="color" value="<?php echo get_option('wjcp_info-bar-text-color'); ?>">
        </div>
        <div>
            <label for="info-bar-background-color-picker">Kolor tła: </label>
            <input name="wjcp_info-bar-background-color" id="info-bar-background-color-picker" type="color" value="<?php echo get_option('wjcp_info-bar-background-color'); ?>">
        </div>
        
        <div>
            <label for="info-bar-position">Pozycja paska: </label>
            
            <select name="wjcp_info-bar-position" id="info-bar-position" >
            <option value="top" <?php if (get_option('wjcp_info-bar-position') == 'top'){ echo "selected"; }   ?> >na górze ekranu</option>
            <option value="center" <?php if(get_option('wjcp_info-bar-position') == 'center'){echo 'selected';}  ?> >na środku ekranu</option>
            <option value="bottom" <?php if(get_option('wjcp_info-bar-position') == 'bottom'){echo 'selected';}  ?>>na dole ekranu</option>
            </select>
        </div>    
		
		<?php submit_button('Zapisz zmiany'); ?>
	</form>
</div>
<?php };
                 


//css main
add_action('wp_print_styles','info_bar_style');

function info_bar_style()
{
    ?> 
        <style>
            div.info-bar-wrapper{
            position:fixed;
            <?php switch (get_option('wjcp_info-bar-position')) {
                case 'top':
                    echo "top:0;";
                    break;
                case 'center':
                    echo "top:50vh;
                    transform:translateY(-50%);";
                    break;
                case 'bottom':
                    echo "bottom:0;";
                    break;
                default:
                    echo "top:50vh;";
                    break;
            }?>;
            left:0;
            
            width:100%;
            background-color:<?php echo get_option('wjcp_info-bar-background-color'); ?>;
            padding:20px;
            cursor:pointer;
            z-index:9999;
            }
            div.info-bar-wrapper *{
                margin:10px;
            }
            div.info-bar-wrapper p{
                color:<?php echo get_option('wjcp_info-bar-text-color'); ?>;
                text-align:center;
                max-width:70%;
            margin:0 auto;}
            span.info-bar-header{
                display:inline-block;
                width:100%;
                font-size:2rem;
                font-weight:bold;
                color:<?php echo get_option('wjcp_info-bar-text-color'); ?>;
                margin: 0;
                text-align:center;
                
            }
            p.info-bar-content{
                max-width:600px;
                margin:0 auto;
            }
            .info-bar-option-page-wrapper{
                color:red ;
            }
        </style>
        <?php
};


//css admin page
add_action('admin_head','info_bar_options_style');

function info_bar_options_style(){
    ?>
    <style>
        .info-bar-option-page-wrapper{
            padding:30px;
        }
        .info-bar-option-page-wrapper div{
            margin:10px;
        }
        .info-bar-option-page-wrapper div *{
            vertical-align: middle;
            
        }
        .info-bar-option-page-wrapper label{
            display:inline-block;
            width:110px;
        }    
        .info-bar-option-warning{
            color:red;
            font-weight:bold;
        }
        .info-bar-option-page-wrapper header{

            width:100%;
            height:50px;
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .info-bar-head-title{
            margin: 20px 0;
            font-size:32px;
            font-weight:bold;
        }
        
    </style>
    <?php
};