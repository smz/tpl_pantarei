# tpl_pantarei
_Panta Rei_ (πάντα ρει) - A semantic HTML5 template for Joomla

### What is this?
This is an ongoing effort to design my own Joomla template, for my own needs, with my personal idiosyncrasies, and using my questionable coding style.
In no way this is meant as criticism to the official Joomla templates.
### What is peculiar in this template?
I'm trying to leverage HTML5 elements to their maximum in order to generate HTML code that will correctly pass the W3C validator, with a paricular attention as far as concern the "outline" of the generated document. In that sense I call it "semantic".
### No microdata?
No. I don't belive in microdata, unless used with a **great** effort to correctly describe **my content** and not the general markup of my HTML.
### What are all those $h6_xxx?
Those are headers for each of the sections in my template: they are meant as "hints" to the W3C validator (and hopefully search engines). All are defined as "language strings" in the Joomla sense and you can override/modify them, but I'd say that if you don't want them it is better to hide them through CSS in your custom.css more than geld them.
### There are a lot of JLayouts...
Yes, I'm using JLayouts a lot, even when and where it is probably not considered a good idea. As an example, what in standard Joomla is the "article" template, here is implemented as a Jlayout. This has permitted me to re-use the same "article" JLayout for both the "Single Article" and the "Category Blog" views.
### You have namespaced most of your JLayouts...
Yes, just to play it safe and not collide with anything defined in Joomla. The ones which are not namespaced right now comes directly from Protostar, so I think this is safe and fair enough.
### Why the standard Twitter Bootstrap is there?
Just in case... For testing... No particular reason. The default is to use the JUI version. You can get rid of the standard one if you wish. I, for one, normally use the JUI one.
### Is this an acomplished work?
Absolutely **not**: it is a "living" thing that I modify from time to time according to my needs and available time.
### Does it break B/C?
It depends on what you intend. There is no core hack, so not in that sense, but the markup I generate (position of various elements, CSS class names, etc..) is probably very different from what you see in standard Protostar.
### May I use it?
Of course you can, if you're brave enough! It's GNU/GPL V3, of course!
### Are there bugs?
I'd say that there or good odds that some bug has slipped in...
### Do you accept contributions/PRs?
They are most welcome! (But at the end of the day **I** decide what goes in and what is rejected. Hey, guys, that's **my** pet template after all...)
### Something more?
This template play nicely with my navbar (https://github.com/smz/mod_smz_navbar). Have a look at that too, if you're interested: not the best in the world but it fits my normal needs...

Have a nice day, everybody!
