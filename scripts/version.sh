#!/bin/bash

VERSION="$1"

echo
echo "Updating version to ${VERSION}"

echo
echo "In opensums-wp-dev.php"
sed -i -E "s/(Version:\s*)[0-9].*$/\1${VERSION}/" opensums-wp-dev.php
grep -n "Version:" opensums-wp-dev.php

echo
echo "In src/Plugin.php"
sed -i -E "s/(VERSION = ')[0-9].*(')/\1${VERSION}\2/" src/Plugin.php
grep -n "VERSION =" src/Plugin.php

echo
echo "In phpdoc.xml"
sed -i -E "s/(v)[0-9].*(<\/title>)/\1${VERSION}\2/" phpdoc.xml
grep -n "<title>" phpdoc.xml
