=== Leaky Paywall - Subscriber Downloads ===
Contributors: layotte, endocreative
Tags: metered, paywall, downloads, membership
Requires at least: 5.0
Tested up to: 6.8.2
Stable tag: 1.5.1

Let's you obfuscate any link to any file in your media library.

== Description ==

Let's you obfuscate any link to any file in your media library. Requiring a user to have a valid Leaky Paywall subscription before downloading content.

More info at https://leakypaywall.com

== Installation ==

1. Upload the entire `leaky-paywall-subscriber-downloads` folder to your `/wp-content/plugins/` folder.
1. Go to the 'Plugins' page in the menu and activate the plugin.

== How to restrict a file to subscriber views only ==

After installation create a link to your file with this format:

http://yoursite.com/?leaky-paywall-media-download=media_id

media_id is the ID of the attachment (found in the media section of WP)

== Frequently Asked Questions ==

= What are the minimum requirements for zeen101's Leaky Paywall - Subscriber Downloads? =

You must have:

* WordPress 5.8 or later
* PHP 7
* Leaky Paywall version 4.0.0 or later

= How is Leaky Paywall - Subscriber Downloads Licensed? =

* Leaky Paywall - Subscriber Downloads is GPL

== Changelog ==

= 1.5.1 =
* Fix array error
* Add new updater

= 1.5.0 =
* Fix call to Leaky Paywall settings
* Update updater class

= 1.4.1 =
* Update download function

= 1.4.0 =
* Add check for multiple subscriptions

= 1.3.0 =
* Add license key settings
* Add specific level setting to media file

= 1.2.0 =
* Update compatibility with Leaky Paywall
* Clean up references to IssueM

= 1.1.0 =
* Updates for public release of Leaky Paywall
* General code cleanup

= 1.0.0 =
* Initial Release

== License ==

Leaky Paywall - Subscriber Downloads
Copyright (C) 2011 The Complete Website, LLC.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
