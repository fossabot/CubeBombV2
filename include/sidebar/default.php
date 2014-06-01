<div class="avatar" style="background-image: url(/data/avatars/<?php echo urlencode(strtolower($user["username"])); ?>.png);"></div>
                    <div class="block">
                        <div class="info">
                            <div class="sprite sprite-cubes"></div>
                            <span class="counter"><?php echo number_format($user["cubes"]); ?></span>
                            <span class="hint">Cubes</span>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-message"></div>
                            <span class="hint">Messages</span>
                            <span class="counter"><?php echo number_format($user["messages"]); ?></span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-burst"></div>
                            <span class="hint">Notifications</span>
                            <span class="counter">2</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="rule"><div class="text">Quick Links</div></div>
                        
                        <div class="button">
                            <div class="sprite sprite-pencil"></div>
                            <span class="title">Edit Profile</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-gear"></div>
                            <span class="title">Settings</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-tag"></div>
                            <span class="title">Inventory</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-foot"></div>
                            <span class="title">Friend Activity</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <?php if ($user["permissions"] >= $_PMOD){ ?>
                    <div class="block">
                        <div class="rule"><div class="text">Moderation</div></div>
                        
                        <div class="button">
                            <div class="sprite sprite-camera"></div>
                            <span class="hint">Images</span>
                            <span class="counter">7</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-flag"></div>
                            <span class="hint">Reports</span>
                            <span class="counter">11</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <?php } 
                    
                        if ($user["permissions"] >= $_PADMIN){
                    ?>
                    <div class="block">
                        <div class="rule"><div class="text">Administration</div></div>
                        
                        <div class="button">
                            <div class="sprite sprite-computer"></div>
                            <span class="title">Admin Panel</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-key"></div>
                            <span class="title">Page Lock</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-clock"></div>
                            <span class="title">Page History</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-chat"></div>
                            <span class="hint">Notes</span>
                            <span class="counter">2</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="block">
                        <div class="rule"><div class="text">Friends Online</div></div>
                        <p>You have no friends online.</p>
                        <!--<div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>-->
                    </div>