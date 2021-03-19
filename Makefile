.PHONY: install update

composer.lock: composer.json
	composer update

vendor: composer.lock
	composer install

install: vendor

test: composer.json
	composer tests

.PHONY : help
help :
	@echo "install	: Install all dependencies"
	@echo "test	: Run test php unit on app"
