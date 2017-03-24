                <?php 
                
                set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
                require_once("inc/classes/Search.php"); 
                
                $useDefault = true;
                if(isset($_SESSION['searchData'])) {
                    $useDefault = false;
                    $data = $_SESSION['searchData'];
                }
                ?>
                
                
                
                <div class="searchForm">
                    <h2>Search Our Listings</h2>
                    <form method="post" action="/processes/post_property_search.php" name="property_search">
                        <ul>
                            <li class="mainsearch">
                                <input type="text" tabindex="1" name="mainsearch" class="txt border_radius" value="<?php echo ($useDefault ? Search::DEFAULT_ADDRESS : $data['mainsearch']); ?>"/>
                            </li>
                            <li class="subsearch">
                                <label>Rent:</label>
                                <input type="text" tabindex="2" name="rentMin" class="txt border_radius" value="<?php echo ($useDefault ? Search::DEFAULT_RENTMIN : $data['rentMin']); ?>"/>
                                <label>to</label>
                                <input type="text" tabindex="3" name="rentMax" class="txt border_radius" value="<?php echo ($useDefault ? Search::DEFAULT_RENTMAX : $data['rentMax']); ?>"/>
                            </li>
                            <li class="subsearch">
                                <label># of Bedrooms</label>
                                <select name="bedroomnum" class="border_radius">
                                <?php for($i = 1; $i <= 5; $i++) {
                                    $selected = "";     
                                    if(!$useDefault  && $i == $data['bedroomnum']) {
                                        $selected = 'selected="selected"';
                                    }
                                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>' . "\n";
                                    ?>
                                    
                                <?php } ?>
                                </select>
                            </li>
                            <li class="subsearch">
                                <label># of Bathrooms</label>
                                <select name="bathroomnum" class="border_radius">
                                    <?php for($i = 1; $i <= 4; $i++) {
                                    $selected = "";     
                                    if(!$useDefault && $i == $data['bathroomnum']) {
                                        $selected = 'selected="selected"';
                                    }
                                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>' . "\n";
                                    ?>
                                    
                                <?php } ?>
                                </select>
                            </li>
                            <li class="subsearch checkbox">
                                <input type="checkbox" tabindex="6" name="onlyavailable" checked="checked"/><label>Only show available listings</label>
                            </li>
                            <li class="submitsearch">
                                <input  tabindex="7" type="image" class="btn" src="/image/RefineSearch.png"/>
                            </li>
                        </ul>
                    </form>
                    <script type="text/javascript" src="/js/searchForm.js"></script>
                </div>