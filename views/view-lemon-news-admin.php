<div class="wrap">

    <div class="header">
        <h1>
            <img class="logo" src="<?php echo LEMONJUICE_PLUGIN_URL; ?>img/logo.png" alt="LemonNews"> 
            <span data-toggle="tooltip" data-placement="left" title="<?php echo __("Total number of registered e-mails", "LemonNewsDomain"); ?>" class="well pull-right ttip"><?php echo $countEmails; ?></span>
        </h1>
    </div>
    <?php require_once LEMONJUICE_PLUGIN_VIEWS_PATH . "view-flash.php"; ?>

    <div class="tabbable">
        <ul class="nav nav-tabs menu">
            <li <?php echo !isset($search) ? "class=\"active\"" : ""; ?> >
                <a href="#tab-options" data-toggle="tab"><?php echo __("LemonNews Options", "LemonNewsDomain") ?></a>
            </li>
            <li>
                <a href="#tab-emails-list" data-toggle="tab"><?php echo __("E-mails List", "LemonNewsDomain") ?></a>
            </li>
            <li <?php echo isset($search) ? "class=\"active\"" : ""; ?>>
                <a href="#tab-search" data-toggle="tab"><?php echo __("E-mail Search", "LemonNewsDomain"); ?></a>
            </li>
            <li>
                <a href="#tab-export" data-toggle="tab"><?php echo __("Export List", "LemonNewsDomain"); ?></a>
            </li>
            <li>
                <a href="#tab-thanks" data-toggle="tab"><?php echo __("Special Thanks", "LemonNewsDomain"); ?></a>
            </li>
            <li>
                <a href="#tab-donate" data-toggle="tab"><?php echo __("Donate", "LemonNewsDomain"); ?></a>
            </li>
            <li>
                <a href="#tab-help" data-toggle="tab"><?php echo __("Help", "LemonNewsDomain"); ?></a>
            </li>
        </ul>
      
        <div class="tab-content">
            <!-- TAB OPTIONS -->
            <div class="tab-pane <?php echo !isset($search)? "active" : ""; ?>" id="tab-options">
                <div class="well">
                    <p><?php echo __("General options so you can customize your plugin ;)", "LemonNewsDomain"); ?></p>
                    <form id="form-options" method="post" action="?page=lemon-news&action=save">
                        <div class="control-group">
                            <label for="userHelp" class="ttip" title="<?php echo __("Will be displayed above the registration form on your site", "LemonNewsDomain"); ?>" ><?php echo __("User Help", 'LemonNewsDomain'); ?></label>
                            <input type="text" id="userHelp" name="data[userHelp]" value="<?php echo isset($userHelp) ? $userHelp : "" ?>" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="control-group">
                            <label for="formStyle"><?php echo __("Style", "LemonNewsDomain"); ?></label>
                            <select name="data[formStyle]" id="formStyle">
                                <option value="Blank"><?php echo __("Blank", "LemonNewsDomain"); ?></option>
                                <?php foreach ($widStyle as $style): ?>
                                    <option <?php echo ($lemon_news_style == $style['slug']) ? "selected='selected'" : ''; ?> value="<?php echo $style['slug']; ?>"><?php echo $style['name']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <img id="stylePreview" src="<?php echo LEMONJUICE_PLUGIN_URL; ?>img/form-samples/<?php echo $lemon_news_style; ?>.png" alt="">
                        </div>
                        <div class="clearfix"></div>
                        <div class="control-group">
                            <label for="customCss"><?php echo __("Insert your custom style here.", true) ?></label>
                            <small><?php echo __("All our css classes are described below so it makes it easier to customize.", true) ?></small>
                            <br>
                            <textarea name="data[customCss]" cols="100" rows="10" id="customCss"><?php echo $customCss; ?></textarea>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary"><?php echo __("Submit", "LemonNewsDomain"); ?></button>
                    </form>
                </div>
            </div>
            <!-- END OF TAB OPTIONS -->
            <!-- TAB EMAILS LIST -->
            <div class="tab-pane" id="tab-emails-list">
                <div class="well">
                    <input type="hidden" value="<?php echo $nonce; ?>" id="nonce">
                    <?php if (count($emailsList) > 0): ?>
                    <h3><?php echo __("List of registered e-mails", "LemonNewsDomain"); ?><img id="emails-ajax-loader" src="<?php echo LEMONJUICE_PLUGIN_URL ?>img/ajax-loader.gif" alt=""></h3>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <td><?php echo __("ID", "LemonNewsDomain"); ?></td>
                                <td><?php echo __("Date Registered", "LemonNewsDomain"); ?></td>
                                <td><?php echo __("Date Modified", "LemonNewsDomain"); ?></td>
                                <td><?php echo __("E-mail", "LemonNewsDomain"); ?></td>
                                <td><?php echo __("Actions", "LemonNewsDomain"); ?></td>
                            </tr>
                        </thead>
                        <tbody id="list-email-body">
                            <?php foreach ($emailsList as $item) : ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->date_created; ?></td>
                                <td><?php echo (empty($item->date_modified)) ? '--' : $item->date_modified; ?></td>
                                <td><a href="#" class="ttip btn-edit" data-toggle="tooltip" title="<?php echo __("Click here to edit this e-mail address", "LemonNewsDomain"); ?>" name="edit-<?php echo $item->id; ?>"><?php echo $item->email; ?></a></td>
                                <td><a href="?page=lemon-news&action=delete&id=<?php echo $item->id; ?>" class="ttip btn btn-mini btn-danger btn-delete" data-toggle="tooltip" title="<?php echo __("Click here to remove this record", "LemonNewsDomain"); ?>" name="delete-<?php echo $item->id; ?>" ><i class="icon-remove icon-white"></i></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                    <h1><?php echo __("No e-mails registered yet =(", "LemonNewsDomain"); ?></h1>
                    <?php endif ?>
                </div>
                <?php if ($pageQuantity > 0): ?>
                    <div class="pagination">
                        <ul id="list-emails-pagination">
                            <?php for ($i=0; $i < $pageQuantity; $i++) : ?>
                                <li id="page-<?php echo $i; ?>" class="<?php echo $i == $pageSelected ? 'active' : ''; ?>"><a href="#"><?php echo $i+1; ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
            <!-- END OF TAB EMAILS LIST -->
            <!-- TAB SEARCH -->
            <div id="tab-search" class="tab-pane <?php echo isset($search)? "active" : ""; ?>">
                <div class="well">
                    <h3><?php echo __("Search", "LemonNewsDomain"); ?></h3>
                    <form class="navbar-search pull-right" id="form-search" method="post" action="admin.php?page=lemon-news&action=search">
                        <div class="input-append">
                            <input type="text" name="lemon-news-search" class="search-query search-input" placeholder="<?php echo __("Search"); ?>">
                            <button class="btn add-on search-buttom" type="submit"><?php echo __("Search"); ?></button>
                        </div>
                    </form>
                    <?php if (isset($search)): ?>
                        <?php if (empty($searchData)): ?>
                            <h1><?php echo __("Nothing found =(", "LemonNewsDomain"); ?></h1>
                        <?php else : ?>
                            <h4><?php echo __("Search Results", "LemonNewsDomain"); ?></h4>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><?php echo __("ID", "LemonNewsDomain"); ?></td>
                                        <td><?php echo __("E-mail", "LemonNewsDomain"); ?></td>
                                        <td><?php echo __("Actions", "LemonNewsDomain"); ?></td>
                                    </tr>
                                </thead>
                                <tbody id="list-email-body">
                                    <?php foreach ($searchData as $item) : ?>
                                    <tr>
                                        <td><?php echo $item->id; ?></td>
                                        <td><a href="#" class="ttip btn-edit" data-toggle="tooltip" title="<?php echo __("Click here to edit this e-mail address", "LemonNewsDomain"); ?>" name="edit-<?php echo $item->id; ?>"><?php echo $item->email; ?></a></td>
                                        <td><a href="?page=lemon-news&action=delete&id=<?php echo $item->id; ?>" class="ttip btn btn-mini btn-danger btn-delete" data-toggle="tooltip" title="<?php echo __("Click here to remove this record", "LemonNewsDomain"); ?>" name="delete-<?php echo $item->id; ?>" ><i class="icon-remove icon-white"></i></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
            <!-- END OF TAB SEARCH -->
            <!-- TAB EXPORT -->
            <div class="tab-pane" id="tab-export">
                <div class="well">
                    <h3><?php echo __("Export List", "LemonNewsDomain"); ?></h3>
                    <a href="?page=lemon-news&action=export&ext=xls" class="btn btn-success"><?php echo __("Export full list as Microsoft Excel file", "LemonNewsDomain"); ?></a>
                    <a href="?page=lemon-news&action=export&ext=csv" class="btn btn-danger btn-csv"><?php echo __("Export full list as CSV file", "LemonNewsDomain"); ?></a>
                    <a href="?page=lemon-news&action=export&ext=txt" class="btn btn-primary"><?php echo __("Export full list as TXT file", "LemonNewsDomain"); ?></a>
                    <a href="?page=lemon-news&action=export&ext=xml" class="btn btn-danger btn-xml"><?php echo __("Export full list as XML file", "LemonNewsDomain"); ?></a>
                </div>
            </div>
            <!-- END OF TAB EXPORT -->
            <!-- TAB THANKS -->
            <div class="tab-pane" id="tab-thanks">
                <div class="well">
                    <h3><?php echo __("Special Thanks", "LemonNewsDomain"); ?></h3>
                    <?php echo __("We'd like to thank many of our fellow developers who directly or indirectly helped me build this plugin.", "LemonNewsDomain"); ?>
                    <ul>
                        <li><a href="http://twitter.github.io/bootstrap/" target="_blank">Twitter Bootstrap</a></li>
                        <li><a href="http://talkslab.github.io/metro-bootstrap/" target="_blank">Metro Bootstrap</a></li>
                        <li><a href="http://fabien-d.github.io/alertify.js/" target="_blank">Alertify</a></li>
                        <li><a href="http://jquery.com" target="_blank">jQuery</a></li>
                        <li><a href="http://www.osmarmatos.com" target="_blank">Osmar Matos</a></li>
                    </ul>
                </div>
            </div>
            <!-- END OF TAB THANKS -->
            <!-- TAB DONATE -->
            <div id="tab-donate" class="tab-pane">
                <div class="well">
                    <p><?php echo __("I have put a lot of effort into building this plugin for you the best way I could. If this plugin is helping you making your life easier, consider buying me a beer =)", 'LemonNewsDomain'); ?></p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="business" value="vitorrigoni@yahoo.com.br">
                        <input type="hidden" name="lc" value="US">
                        <input type="hidden" name="item_name" value="Vitor Rigoni">
                        <input type="hidden" name="item_number" value="vitorrigoni">
                        <input type="hidden" name="no_note" value="0">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>

                </div>
            </div>
            <!-- END OF TAB DONATE -->
            <!-- TAB HELP -->
            <div id="tab-help" class="tab-pane">
                <div class="well">
                    <h3><?php echo __("Help", "LemonNewsDomain"); ?></h3>
                    <p><?php echo __("There are three different ways to insert this plugin on your website:", "LemonNewsDomain"); ?></p>
                    <ol>
                        <li>
                            <h3><?php echo __("First way: Widget", "LemonNewsDomain"); ?></h3>
                            <p><?php echo __("LemonNews can be used as a widget. Just add it to your sidebar from the widgets panel.", "LemonNewsDomain"); ?></p>
                        </li>
                        <li>
                            <h3><?php echo __("Second way: Shortcode", "LemonNewsDomain"); ?></h3>
                            <p><?php echo __("We have conveniently added a new button to your TinyMCE Editor, so you can add LemonNews directly inside a new post, for example.", "LemonNewsDomain"); ?></p>
                        </li>
                        <li>
                            <h3><?php echo __("Third way: The way of the warrior", "LemonNewsDomain"); ?></h3>
                            <p><?php echo __("So, I see you want the hard mode? You want to prove the true warrior you are. I like that. Place the code below anywhere you want between php tags in your theme files and you're good to go!", "LemonNewsDomain"); ?></p>
                            <code>
                                if (function_exists('add_lemon_news'))
                                    add_lemon_news();
                            </code>
                        </li>
                        <li>
                            <h3><?php echo __("HOLY CRABS! NOTHING WORKS!!", "LemonNewsDomain"); ?></h3>
                            <p><?php echo __("Please relax and e-mail us at contact@lemonjuicewebapps.com. We will gladly do everything in our reach to help you!", "LemonNewsDomain"); ?></p>
                        </li>
                    </ol>
                    <small><?php echo __("Note: The LemonNews registration form will only show up once every page. E.g.: if your post has the shortcode and your sidebar has the widget it'll only show up inside your post, and not in your sidebar.", "LemonNewsDomain"); ?></small>
                </div>
            </div>
        </div>
    </div>
</div>
<small class="credits"><?php echo __("Developed by Vitor Rigoni @ LemonJuice Web Apps", "LemonNewsDomain"); ?></small>






















