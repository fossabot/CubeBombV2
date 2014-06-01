<div class="rule"><div class="text">Sign In</div></div>
                    <div class="gray-bombian"></div>
                    <form action="/api/doLogin.php" success="/profile.php?id=2" style="padding: 12.5px; background-color: #E7E7E7;">
                        <div class="error" style="display: none;"></div>
                        <div class="inputRow condensed">
                            <input name="username" id="lf-username" label="Username" type="text" class="hint" required />
                        </div>
                        <div class="inputRow condensed">
                            <input name="password" id="lf-password" label="Password" type="password" class="hint form-enter" required />
                        </div>
                        <div class="inputRow condensed">
                            <div class="sa-button right submit">Log in</div>
                            <div style="clear: both;"></div>
                        </div>
                    </form>