
<div id="poststuff">
    <div class="postbox sucuriscan-border sucuriscan-table-description">
        <h3>Failed logins</h3>

        <div class="inside">
            <p>
                This information will be used to determine if your site is being victim of a brute-force attack using the
                <a href="http://kb.sucuri.net/definitions/attacks/brute-force/password-guessing" target="_blank">password
                guessing</a> technique. Multiple failed logins will be considered part of the attack if there are more than
                <code>%%SUCURI.FailedLogins.MaxFailedLogins%%</code> during the same hour, that's why you will only see
                <em>(in this table)</em> information of the last hour, previous reports will be sent to your email if you
                checked the alert option in the settings page to receive notifications of brute-force attacks.
            </p>

            <div class="sucuriscan-inline-alert-error sucuriscan-%%SUCURI.FailedLogins.WarningVisibility%%">
                <p>
                    The option to notify possible <strong>password guessing</strong> attacks is
                    disabled, failed logins reports will not be sent to your email when they occur.
                    Go to the <a href="%%SUCURI.URL.Settings%%#settings-notifications">notification
                    settings</a> to enable the brute-force attack alerts.
                </p>
            </div>

            <div class="sucuriscan-inline-alert-error sucuriscan-%%SUCURI.FailedLogins.CollectPasswordsVisibility%%">
                <p>
                    If you type a wrong password by mistake your password, the plugin will log the
                    username and password in the security logs <em>(which are text/plain
                    files)</em>. If someone get access to your API key, or your server fails to
                    process the PHP files <em>(which is not usual but may happen)</em> then an
                    attacker may get your credentials and invade your site. Change this from the <a
                    href="%%SUCURI.URL.Settings%%#settings-general">general settings</a>
                </p>
            </div>
        </div>
    </div>
</div>

<table class="wp-list-table widefat sucuriscan-table sucuriscan-lastlogins-failed sucuriscan-%%SUCURI.IgnoreRules.TableVisibility%%">
    <thead>
        <tr>
            <th width="20">No.</th>
            <th>User</th>
            <th>Password</th>
            <th>IP Address</th>
            <th>Date/Time</th>
            <th width="300">User-Agent</th>
        </tr>
    </thead>

    <tbody>
        %%SUCURI.FailedLogins.List%%

        <tr class="sucuriscan-%%SUCURI.FailedLogins.NoItemsVisibility%%">
            <td colspan="6">
                <em>No logs so far.</em>
            </td>
        </tr>
    </tbody>
</table>
