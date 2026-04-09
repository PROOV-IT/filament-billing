SHELL := /bin/bash

.PHONY: format format-test analyse test qa

format:
	./vendor/bin/pint src tests

format-test:
	./vendor/bin/pint --test src tests

analyse:
	./vendor/bin/phpstan analyse --memory-limit=1G

test:
	./vendor/bin/pest

qa: format-test analyse test
