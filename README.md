Abstract
--------

This website was developed (just for the craic) to manage Goliardi (Italian fraternities).
There is a forum, a chat and all the community stuff that was popular before Facebook.
There's also a very interesting hierarchical management systems for Goliardi belonging
to some Noble Order: Orders/Offices/Roles.

More to follow... See http://www.goliardia.it/ for the production instance.

INSTALL
-------

Install requirements: 
- an IQ over 95 (see `PEBKAC`).
- knowledge of Italian language and English alike.
- knowing how to assemble a LAMP stack with more than just apt-get install
- Compliment Riccardo <riccardo.carlesso@gmail.com>

Get the PHP pages into a LAMP stack. 
Create a MySQL database. Populate with my neat sample DB.

  $ mysql yourdb your user yourpass < db/opengoliardia_sample.sql
	$ cp conf/setup.php.dist conf/setup.php

Change stuff in `conf/setup.php`
You're grand.
If you don't know what I'm talking about then it might be a PEBKAC. Google this.
If you are smart and still have issues I might have done something wrong. In that case, please tell me!

Bugs
----

This website is just *purfect*, also from a typo point of view. :)

Notes
-----

This website is currently in *Italian*, except for this README which is totally in Oirish English.

License
-------

License is GPL v3. See `LICENSE` file

Thanks
------

This website was developed entirely by Riccardo Carlesso <riccardo.carlesso@gmail.com>.

I would like to thank a few people who helped me through it. A few people proved invaluable 
in helping me maintaining the real website. Among them:

- Umberto `Volpini`(Orders images gathering)
- Fabio `Venerdi` Mattei (Development)
- Davide `Karaoke` Fiorello (Development)
- Manuel `Palo` Bernardini (Administration)
- Paola `Vipera` Vallini (Administration)
- Elisa `Farina` Ciccarelli (Administration, icons)
- Daniela `Iside` Malverdi (icons)
- Luca `Npp` Sambucci (DNS redirect)
- `Buddha`, `Kash`,... for past hosting helps
- `Kilhadurolavince`, `Manolus`, `Gimmigod` to alert me when website was down and lots of other stuff :)
- My mum Lucilla for making me the totally awesome man I actually am :)

