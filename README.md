Abstract
--------
 <img src='https://github.com/palladius/goliardia/raw/master/immagini/logoFooterIside.jpg' height='100' align='right' />

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

	$ mysql your_user yourpass your_db < db/opengoliardia_sample.sql
	$ cp conf/setup.php.dist conf/setup.php
  # Change stuff in `conf/setup.php`
	$ execute bin/init.rb # still buggy
	$ login as `prova` // `prova`
  # You're grand :)

If you don't know what I'm talking about then it might be a PEBKAC. 

If you think I might have done something wrong, please tell me!

Filesystem explained
--------------------

I need to mention how the FS is built:

* `/*.php`. This contains most of the logic of the website. I know its shit. I know.
  Its pretty static.
* `/var` contains most changeable stuff: logs, session state, .. needed to make CHAT work,
  people in braghe, and last logins (I know, this could just be done with SQL).
  You reset it and you wipe out the chat, basically.
* `immagini/` this contains images. Mostly static, but `immagini/persone/` keeps growing from
  uploads of people to `/uploads/thumb` which needs to be open in writing. People are manually
  approving this to promote to `immagini/persone/` after which image becomes ACTIVE. I'm working
  on dockerizing this and its giving me a headache, if you have ideas please contact me.

Bugs
----

This website is just *purfect*, also no typos whatsoever. :)

Notes
-----

This website is currently in *Italian*, except for this README which is totally in Oirish-English.

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
- Rudi Bertaccini for itching (or slagging?) my ego: http://www.vgnetwork.it/images/anime/slow-clap.gif

