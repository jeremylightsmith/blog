=== BruteProtect ===
Contributors: samhotchkiss, professor44, roccotripaldi, sdquirk, maverick3x6, dsmartdesign, magicbean
Tags: security, bruteforce, brute force, brute force attack, harden wp, login lockdown, multisite, botnet, wordfence, best security
Requires at least: 3.0
Tested up to: 3.9
Stable tag: trunk

BruteProtect is a cloud-powered Brute Force attack prevention plugin and the best protection against botnet attacks.

== Description ==

= Botnets attack millions of websites everyday using their Internet-connected programs =

BruteProtect is a security plugin that guards against botnets by connecting its users to track every failed login attempt across all installed users of the plugin. When you activate BruteProtect you become a part of an Internet-connected counter force that works against botnets.

= BruteProtect logs every failed attempt community-wide =

When an IP has too many failed attempts in a specific period of time, BruteProtect logs and blocks that IP across the entire BruteProtect network (your site included). The more users of BruteProtect, the safer we all are from traditional brute force attacks, and distributed brute force attacks that use many different servers and IP addresses.

= BruteProtect is safe for MultiSite and compatible with other security plugins =

BruteProtect FULLY SUPPORTS multisite networks, and you’ll only need one API key. Go to the Installation tab to learn more about how easy it is to install and use BruteProtect. You can even use it alongside other security plugins, if you so desire.

== Installation ==

Figures for the below instructions can be found under the Screenshots tab <http://wordpress.org/plugins/bruteprotect/screenshots>

1. Under the Plugins tab in your WordPress admin click the Add New Button - Figure 1
2. Type BruteProtect into the search field - Figure 2
3. Click “Install Now” under the BruteProtect plugin name - Figure 3
4. Once the plugin is installed click “Activate Now”
5. Now you’ll see the new “BruteProtect” tab on the left, click the “API Key” button - Figure 5
6. To get your required API Key confirm your email address in the green box and click “Get an API Key” - Figure 6
7. Your API key is free and will be emailed to you - Figure 7
8. Simply copy your API key out of your email and paste it into the blue box on the right. Once you click “Save API Key” BruteProtect will be up and running
9. Watch for BruteProtect data on failed attempts in your dashboard - Figure 9

== Screenshots ==

1. Figure 1
2. Figure 2
3. Figure 3
4. Figure 5
5. Figure 6
6. Figure 7
7. Figure 9
8. The message shown to those locked out by BruteProtect


== Frequently Asked Questions ==

= How do I get an API Key? =

Once the plugin is installed, you’ll be prompted to request an API Key via the Dashboard.  If you do not receive an API Key, please visit the BruteProtect WordPress support forum to let us know.

= Do I need a different key for each site? =

Yes, each site needs a different key (this is not the case with multisite networks).  Many API keys can be associated with one email address.

= Does it work with other WordPress security plugins? = 

Yes! We haven’t received any reports of plugin incompatibility.  Please visit the BruteProtect WordPress support forum to report any issues.

= Are there any known compatibility issues? = 

No!  We've had no reported compatibility issues with any plugins.

= Is it free? =

Everything that we currently offer will always be free to individuals and small businesses. We may, some day, ask for a (very small) fee from our highest-activity users. We will offer additional “premium” services in spring 2014.

= Does BruteProtect support Multisite Networks? =

Yes.

= How many failed attempts before an IP address will be blocked? =

This number varies based on a number of factors, there isn't a fixed number of failed attempts that equal a block.

= Can I whitelist certain IP addresses? =

Yes, you may add IP addresses under the “whitelist” setting of BruteProtect.  This list only applies to your installation of WordPress.


== Changelog ==

= 2.1 =
* BruteProtect dashboard gets a makeover
* Fixed some broken links
* Fixed the way that beta versions of WP report that they need updating

= 2.0.9.2 =
* Fix minor issue with secure login

= 2.0.9.1 =
* Fix minor issue with secure login

= 2.0.9 =
* Change the hook used for our backstop check to ensure complete effectiveness
* Improve secure login redirect

= 2.0.8.1 =
* Fixing a glitch that deactivated the Secure Login feature
* Improving the urls in the Secure Login feature

= 2.0.8 =
* Improve the way site urls are saved
* Improve how we determine if a site is linked to my.bruteprotect.com

= 2.0.7 =
* Fix minor bug in multisite admin

= 2.0.6 =
* Support for sites where WordPress is installed in a sub folder
* More readable UI
* Fixed bugs that where causing PHP errors

= 2.0.5 =
* Now you can opt out of the Secure Login feature from the login page
* Secure Login is automatically disabled if you are connecting to your site via SSL already

= 2.0.4 =
* Add color options for the front end widget
* Add a site disconneciton button
* Improve plugin deactivation
* Bug fixes in the back end widget

= 2.0.3 =
* Minor fixes to the api calls

= 2.0.2 =
* Use strval on subdirectory url

= 2.0.1 =
* Add in core update
* Minor bug fixes
* Track subdirectory urls

= 2.0 =
* Redesign everything
* Add My BruteProtect
* Add remote secure login
* Add remote monitoring
* Add remote plugin monitoring and updating
* This update includes over 2,000 man hours of programming and design work, and countless sleepless nights.  Thank you to Rocco, Jesse, Stephen, Jeff, Derek and Ryan, and to our incredibly patient significant others.  We really hope that everyone loves what we've done.

= 1.1.6 = 
* Make the security auditing messaging less offensive
* Add in better text around the text requiring users to get a unique API key for each site

= 1.1.5 = 
* Fix offline blocked attempt counter
* Add one-click-clef back in
* Add information about Pro
* Add information about our security auditing

= 1.1.4.1 = 
* Allow for graceful fallback if filter_var isn't available
* Corrected CloudFlare header

= 1.1.4 = 
* Updated API key process to make it even easier (API key is auto-added)
* Updated Math CAPTCHA error handling to help teach people about login form best practices
* Updated IP retrieval function to ensure as few false readings as possible

= 1.1.3 = 
* Bug fix to the API Endpoint

= 1.1.2 = 
* Update API Endpoints

= 1.1.1 =
* Minor bug fixes

= 1.1 =
* Continued code improvements
* Improve troubleshooting options
* Improve methodology for fetching remote IP... using X_FORWARDED_FOR and HTTP_CLIENT_IP if available
* Add options for privacy
* Update icon for 3.8
* Update interface

= 1.0.0.2b =
* Remove 1-click clef until we figure out the bug.

= 1.0.0.1b =
* File got corrupted when uploading to the plugin repository.  All better now

= 1.0b =
* Bite the bullet and say 1.0
* Code stabilization and optimization
* Performance improvements

= 0.9.10 =
* More backwards compatibility

= 0.9.9.9d =
* Squash a bug which caused an error in older versions of PHP

= 0.9.9.9c =
* Integrate Clef install
* Add debug information for hosts, improve copy for sites with broken install

= 0.9.9.9b =
* Remove left over debug code

= 0.9.9.9 =
* Fix error with server identification and errors in older versions of PHP
* Version Codename: I really don't want to say 1.0

= 0.9.9.8 =
* Fix error with cached blocks

= 0.9.9.7 =
* page-now fallback fix

= 0.9.9.6 =
* Fix bug on local environments

= 0.9.9.5 =
* Major code rewrite!  Every line of code was reviewed, optimized, and made prettier.  It can be prettier, though, and we're going to keep working on that
* Blocked users from obtaining a key on a local environment
* Laid groundwork for Clef Integration

= 0.9.9 =
* Add in the ability to whitelist IPs or IP blocks
* Improve wp-login.php performance via $pagenow -- thanks Mark Barnes!

= 0.9.8.6.2 =
* Don't ever block localhost

= 0.9.8.6.1 =
* Fixed typo

= 0.9.8.6 =
* Expired transients now get cleaned up-- thanks KirkM, Tevya, David Anderson, and Seebz!

= 0.9.8.4 =
* Fixed a few PHP parsing notices, thanks Till and clwill!

= 0.9.8.3 =
* Added hooks: brute_log_failed_attempt and brute_kill_login -- both are passed the offending IP address

= 0.9.8.2 =
* Remove unused code from upcoming functionality.

= 0.9.8.1 =
* Admin can now prevent other users from seeing BruteProtect statistics
* Fixed a typo in the admin panel

= 0.9.8 =
* Added a fallback for failed multisite blog count reporting
* Added the ability to hide BruteProtect stats from network blog dashboards

= 0.9.7.2 =
* Fixed a minor display issue in 0.9.7.1

= 0.9.7.1 =
* Fixed a minor display issue in 0.9.7

= 0.9.7 =
* BruteProtect now supports multisite networks!  One key will protect every site in your network, and will always be free for small networks!
* Fixed API URI logic so that we fall back to non-https if your server doesn't support SSL
* Fixed admin config page image (thanks, flick!)
* Added index.php to prevent directory contents from being displayed (thanks, flick!)

= 0.9.6 =
* Admin-side updates for better compatibility and readability -- Thanks again, Michael Cain!

= 0.9.5 =
* Changed API server to HTTPS for increased security
* Improved domain check method even further
* Added a "Settings" link to the Plugins page
* Made things prettier

= 0.9.4 =
* Changed domain check method to reduce API key errors

= 0.9.3 =
* Added hooks in for upcoming remote security and uptime scans

= 0.9.2 =
* Fixed error if Login Lockdown was installed
* Improve admin styling (thanks Michael Cain!)
* Added statistics to your dashboard
* If the API server goes down, we fall back to a math-based human verification

== Upgrade Notice ==

= 2.0.9 =
This upgrade ensures complete protection against XML-RPC based attacks.  Please upgrade immediately.