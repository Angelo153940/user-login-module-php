.PHONY : main build-image build-container start test shell stop clean
main: build-image build-container

build-image:
	docker build -t docker-php-boilerplate .

build-container:
	docker run -dt --name docker-php-boilerplate -v .:/user-login-module-php docker-php-boilerplate
	docker exec docker-php-boilerplate composer install

start:
	docker start docker-php-boilerplate

test: start
	docker exec docker-php-boilerplate ./vendor/bin/phpunit tests/$(target)

shell: start
	docker exec -it docker-php-boilerplate /bin/bash

stop:
	docker stop docker-php-boilerplate

clean: stop
	docker rm docker-php-boilerplate
	rm -rf vendor
