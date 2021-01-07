
fix-permissions:
	chmod 777 uploads/thumb/
	chmod 777 var/state/
	chown -R www-data var/

pull:
	git pull origin master
push:
	git push origin master

docker-compose-up:
	docker-compose up

docker-compose-restoredb:
	bin/dockercompose-restoredb

docker-compose-down:
	echo Se non basta digita: docker-compose down --remove-orphans 
	docker-compose down

