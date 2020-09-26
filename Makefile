
fix-permissions:
	chmod 777 uploads/thumb/
	chmod 777 var/state/
	chown -R www-data var/

pull:
	git pull origin master
push:
	git push origin master
