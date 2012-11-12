=== Clobber spam users ===

Contributors: salzano
Donate link: http://www.tacticaltechnique.com/donate/
Tags: spam, spam posts, delete users, ugc, delete posts, blog spam
Requires at least: 3.0.0
Tested up to: 3.4.2
Stable tag: 0.121111

This plugin makes it easy to delete spam posts submitted to your website by creating a 
dashboard called "Clobber Spam" in your Users menu.

== Description ==

Deleting spam posts from your website is much easier with this plugin. With a click of a 
button, you can delete all the posts created by spammer accounts and prevent anyone from
logging into an account that you have clobbered. A new administrative page is created to
allow this moderation under the Users menu.

== Installation ==

1. Login to your administration dashboard
1. Click Add New under the plugins menu
1. Type 'clobber spam users' into the search box and press the Search Plugins button
1. Locate Clobber spam users by Corey Salzano in the search results and click Install Now
1. Click Activate Plugin after the installation finishes
1. Visit Clobber Spam under the Users menu of your dashboard to use the plugin

== Frequently Asked Questions ==

= What does this thing do? =

This plugin adds a menu item to the Users menu of your administration dashboard. Click 
this new "Clobber Spam" link and you will see a page that puts the most recently created 
user names next to the email address and the title of the most recently created post by 
that user. You can check a box next to the users you believe are spam and click a button 
to delete all their posts and prevent them from logging in ever again.

= Why not just delete the users? = 

Because the software these spammers use will try to submit more than one post for each 
account, sometimes days later. If you delete the user, the same user name can be 
recreated. By keeping the user and changing the password and email address, we prevent 
that account from being used. The spam software is forced to create a new account to 
continue bothering us. Also, I already use a really good plugin to delete old and unused 
user accounts. It is called <a href="http://wordpress.org/extend/plugins/inactive-user-deleter/">Inactive User Deleter</a> by shra and I regularly 
use it to delete users with no posts and no comments that are at least 6 months old.

= Can this process of deleting spam post submissions be automated? =

I would love to build the "akismet for posts" because I could make a lot of money selling 
it. I have been using <a href="http://wordpress.org/extend/plugins/ban-hammer/">Ban Hammer</a> and <a href="http://wordpress.org/extend/plugins/stop-spammer-registrations-plugin/">Stop Spammer Registrations</a> 
and I still decided to build this plugin to handle about 50 posts a week that these 
plugins are failing to prevent.

= Can you add feature X? =

Send me your idea, and we can have a conversation.

== Screenshots ==

1. This is what the Clobber Spam page looks like in the administrative dashboard

== Change Log ==

= 0.121111 = 

* Added a javascript alert for users that click the Clobber button before checking any users
* Added a conditional to the loop that deletes posts to make sure a user ID is provided

= 0.121030 =

* Added a handler for posts that are saved with no title

= 0.121015 =

* Fixed a javascript bug that prevented the main routine from executing on checked users

= 0.121013 =

* First build

== Upgrade Notice ==

= 0.121111 = 

A user left a bad review and identified a bug in this plugin that deleted posts he did not want to delete. I believe he was clicking the Clobber Users button without checking any users on the page, and this plugin would then delete every post from the database. It no longer does that!

= 0.121030 = 

This update will now display [a post saved with no title] on the clobber spam dashboard if a post is saved with no title

= 0.121015 = 

This version is an important update because it fixes a bug

= 0.121013 =

First build