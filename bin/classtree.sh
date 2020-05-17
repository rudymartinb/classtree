#!/usr/bin/env bash
PHP=`which php`
DIR="$(dirname "$(readlink -f "$0")")"
$PHP $DIR/classtree.php $1 $2

