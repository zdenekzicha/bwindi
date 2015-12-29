=== Automatic NBSP ===
Contributors: damian-gora
Tags: typography, nbsp, non-breaking space, line-break, polish, czech, french, punctuation marks, sierotki
Requires at least: 3.0
Tested up to: 4.3.1
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Automatically adds a non-breaking space (&nbsp) in the content.

== Description ==

**Support typographic rules in Polish and Czech**
Moves conjunctions, prepositions, etc. to the new line. ( sierotki )

**Support punctuation marks in French**
Adds a non-breaking space `&nbsp;` before punctuation marks as `!` `?` `;` `%` `«` `»`

**How it works?**
The plugin automatically adds HTML entity `&nbsp;` ( non-breaking space ) after selected words or phrases. E.g. 'Mr. Someone' should be 'Mr.`&nbsp;`Someone'. Works with:

*   posts
*   titles
*   pages
*   custom post types
*   comments
*   widgets
*   custom contents

You can create your own list of words/phrases or import our proposals.


**Custom contents**
You can use the function `<?php auto_nbsp($content, $echo); ?>` to add `&nbsp;` to the custom content. Use this in your code.
1. Param `$content` - (string) (required) Free text
2. Param `$echo` - (bool) (optional) true (echo), false (return), Default: true 

**Other features:**
*   Keep numbers together ( option )

If you have any ideas for how Automatic NBSP could be improved, you write to us.

== Installation ==

1. Install the plugin from within the Dashboard or upload the directory `automatic-nbsp` and all its contents to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings -> Automatic NBSP and set your preferences.
4. Enjoy automatically added non-breaking spaces


== Changelog ==

= 1.5 =
*   ADD Keep numbers together as option
*   FIX Bug with words ending with a dot `.`

= 1.4 =
*   FIX Bug with disappearing titles.

= 1.3 =
*   ADD New function `auto_nbsp($content, $echo)` allows to add nbsp to the custom content. Use this in your code.
*   ADD `&nbsp;` before punctuation marks as `!` `?` `;` `%` `«` `»`

= 1.2 =
*   Title is now supported.
*   Excerpt is now supported.
*   Comment text is now supported.
*   Widget text is now supported.
*   Phrases is now allowed.
*   Add case sensitive for words or phrases.
*   Add list of conjunctions and other phrases for the Polish and English language.
*   Fix mechanism for adding a &nbsp entitie.
*   Polish translation

= 1.1 =
*   Fix bug compatibility wordpress 3.6.

= 1.0 =
*   First version.
