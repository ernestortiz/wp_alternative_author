=== Alternative Author ===
Contributors: ernestortiz
Donate link: 
Tags: user, author, alternative author
Requires at least: 3.2
Tested up to: 4.4.2
Stable tag: trunk
License: GPLv2 or later

Consider an alternative post author (without creating a wordpress user as author).

== Description ==

This is a simple way of consider an alternative post author (without creating a wordpress user as author).
When you open your post, you can notice a new 'Alternative Author' metabox, with three fields: full name, link and data.
If you write an alternative author's full name, this person will appear as the author of the post instead of the person in wordpress Author metabox (and pointing to the alternative link instead of the wordpress author's page).

== Installation ==

Upload the Alternative Author plugin to your blog, Activate it. You're done!

== Upgrade Notice ==

== Changelog ==

	= 1.0 =
	*Release Date - March 2016*
	
== Screenshots ==

== Frequently Asked Questions ==

	= How I show the alternative author description on my theme? =

	At this current version, the way to do this is through two functions provided by this plugin (has_alter_author and get_alter_descr).
	You can write a code on your theme similar to the following:
	
	<?php 
		if (has_alter_author()){
			echo get_alter_descr();
		}else{
			the_author_meta('description');
		}
	?>

== Donation ==

If you want to make a contribution, please do it through PAYPAL, to ernestortizcu@yahoo.es.
Thanks in advance.
