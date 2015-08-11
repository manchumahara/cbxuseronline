===  CBX User Online ===
Contributors: manchumahara, codeboxr, wpboxr
Donate link: http://wpboxr.com
Tags: woocommerce, woocommerce order
Requires at least: 3.0
Tested up to: 4.2.2
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows online users based on cookie for guest and session for registered user

== Description ==

This plugin helps to show online users. Member, guest and bot can be tracked, their counts, most users online etc.

Features:

*   Cookie for guest user and login session check for registered user which tracks users perfectly.
*   Most user online count and date
*   Shortcode and widget based display
*   Username, ip, user agent, is from mobile or desktop etc are tracked
*   Simple plugin option  to set refresh time
*   Show logged in member as online list
*   Show site or specific page's online user statistics
*   Dynamically created cookie name for guest visitor

See more details and usages guide here http://wpboxr.com/product/cbx-user-online-for-wordpress

Upcoming feature:

*   Auto refresh statistics using ajax
*   Admin dashboard widget
*   Show online count in dashboard widget "Right Now"
*   Create admin page to show current online user's total list for admin only
*   Integrate this plugin with other plugins where possible


Shortcode Details:

[cbxuseronline]

for other params

count             default value 1 //show user count
count_individual  default value 1 //show individual count as per user type  member, guest and bot
member_count      default value 1 //show member user type count
guest_count       default value 1 //show guest user type count
bot_count         default 1  //show bot user type count
page              default 0 //show count for this page
mobile            default 1 //show user mobile or desktop login information
memberlist        default 1 //show member list
mostuseronline    default 1 //most user online date and count


== Installation ==

How to install the plugin and get it working.


1. Upload `cbxuseronline ` folder  to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Setting-> CBX Useronline to edit settings
4. In any post or page you can write shortcode [cbxuseronline]


== Frequently Asked Questions ==

= what's the cookie name left in browser  ? =

Cookie name is "cbxuseronline-cookie", value is created dynamically






== Screenshots ==

1. Widget Setting
2. Widget frontend
3. Shortcode frontend

== Changelog ==

= 1.0.0 =
* First Release

