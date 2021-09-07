#!/bin/bash

set -eux

cd ~/laravel_portfolio/backend
php artisan migrate --force
php artisan config:cache