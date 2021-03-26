.PHONY: install update

composer.lock: composer.json
	composer update

package.lock: package.json.
	npm update

node-modules: package.lock
	npm install

vendor: composer.lock
	composer install

install: vendor node_modules

test: composer.json
	composer tests

.PHONY : help
help :
	@echo "install	: Install all dependencies"
	@echo "test	: Run test php unit on app"
